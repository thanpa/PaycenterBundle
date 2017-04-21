<?php

namespace Thanpa\PaycenterBundle\Service;

use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use Thanpa\PaycenterBundle\Entity\TransactionTicket;
use Thanpa\PaycenterBundle\Interfaces\TicketIssuerInterface;
use Thanpa\PaycenterBundle\TicketIssue\TicketIssueRequest;

/**
 * Class TicketIssuer
 * @package Thanpa\PaycenterBundle\Service
 */
final class TicketIssuer implements TicketIssuerInterface
{
    /** @var int */
    private $acquirerId;

    /** @var int */
    private $merchantId;

    /** @var int */
    private $posId;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $requestType = '02';

    /** @var int */
    private $currencyCode = 978;

    /** @var string */
    private $merchantReference;

    /** @var float */
    private $amount;

    /** @var string */
    private $installments = 0;

    /** @var string */
    private $expirePreAuth = '0';

    /** @var int */
    private $bnpl = 0;

    /** @var string */
    private $parameters;

    /** @var string Request url */
    private $url;

    /** @var Client */
    private $client;

    /** @var EntityManager */
    private $manager;

    /**
     * TicketIssuer constructor.
     * @param Client        $client     Guzzle Client
     * @param int           $acquirerId Acquirer Id
     * @param int           $merchantId Merchant Id
     * @param int           $posId      Pos Id
     * @param string        $username   Username
     * @param string        $password   Password
     * @param string        $url        Url
     * @param EntityManager $manager    EntityManager
     */
    public function __construct(
        Client $client,
        $acquirerId,
        $merchantId,
        $posId,
        $username,
        $password,
        $url,
        EntityManager $manager)
    {
        $this->client = $client;
        $this->acquirerId = $acquirerId;
        $this->merchantId = $merchantId;
        $this->posId = $posId;
        $this->username = $username;
        $this->password = $password;
        $this->url = $url;
        $this->manager = $manager;
    }

    /**
     * Get md5'ed password
     *
     * @return string
     */
    public function getPassword()
    {
        return md5($this->password);
    }

    /**
     * Set request type
     *
     * @param string $requestType Request Type
     * @return TicketIssuer
     */
    public function setRequestType($requestType)
    {
        $this->requestType = $requestType;

        return $this;
    }

    /**
     * Set currency code
     *
     * @param int $currencyCode Currency Code
     * @return TicketIssuer
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    /**
     * Set Merchant Reference
     *
     * @param string $merchantReference Merchant Reference
     * @return TicketIssuer
     */
    public function setMerchantReference($merchantReference)
    {
        $this->merchantReference = $merchantReference;

        return $this;
    }

    /**
     * Set amount
     *
     * @param float $amount Amount
     * @return TicketIssuer
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Set Installments
     *
     * @param int $installments Installments
     * @return TicketIssuer
     */
    public function setInstallments($installments)
    {
        $this->installments = $installments;

        return $this;
    }

    /**
     * Set Expire Pre Auth
     *
     * @param string $expirePreAuth
     * @return TicketIssuer
     */
    public function setExpirePreAuth($expirePreAuth)
    {
        $this->expirePreAuth = $expirePreAuth;

        return $this;
    }

    /**
     * Set parameters
     *
     * @param string $parameters Parameters
     * @return TicketIssuer
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Makes a request to ticket issuer mechanism to get a transaction ticket
     *
     * @return string Transaction Ticket returned from bank
     * @throws \Exception If merchant reference is not specified,
     *                    or if Transaction Ticket system does not return a valid response
     */
    public function getTicket()
    {
        if ($this->merchantReference === null) {
            throw new \Exception('MerchantReference is required for TicketIssuer');
        }
        if (!is_numeric($this->amount) || $this->amount <= 0) {
            throw new \Exception('Amount should be a number higher than zero');
        }

        $response = $this->client->post($this->url, [
            'body' => TicketIssueRequest::getBody($this->getXmlFields()),
            'headers' => ['Content-Type' => 'application/soap+xml; charset=utf-8'],
        ]);

        $reader = new \DOMDocument();
        $reader->loadXML($response->getBody());

        $xpath = new \DOMXPath($reader);
        $nodeXPath = '//*[local-name()=\'%s\']';

        // check result code if request completed successfully
        $resultCode = $xpath->query(sprintf($nodeXPath, 'ResultCode'))->item(0)->nodeValue;
        if ($resultCode != '0') {
            $errorDescription = $xpath->query(sprintf($nodeXPath, 'ResultDescription'))->item(0)->nodeValue;
            throw new \Exception(sprintf('TicketIssuer failed: %s', $errorDescription));
        }

        $generatedTicket = $xpath->query(sprintf($nodeXPath, 'TranTicket'))->item(0)->nodeValue;

        $this->saveTicket($this->merchantReference, $generatedTicket);

        return $generatedTicket;
    }

    /**
     * Saves generated ticket in database
     *
     * @param string $merchantReference Merchant reference
     * @param string $generatedTicket   Generated ticket
     */
    private function saveTicket($merchantReference, $generatedTicket)
    {
        $existing = $this->manager
            ->getRepository('ThanpaPaycenterBundle:TransactionTicket')
            ->findOneBy(['merchantReference' => $merchantReference]);

        if ($existing !== null) {
            $this->manager->remove($existing);
        }

        $transactionTicket = new TransactionTicket($merchantReference, $generatedTicket);
        $this->manager->persist($transactionTicket);
        $this->manager->flush();
    }

    /**
     * Returns an array with all XML fields that should be sent for the ticket
     *
     * @return array
     */
    private function getXmlFields()
    {
        return [
            'Username' => $this->username,
            'Password' => $this->getPassword(),
            'MerchantId' => $this->merchantId,
            'PosId' => $this->posId,
            'AcquirerId' => $this->acquirerId,
            'MerchantReference' => $this->merchantReference,
            'RequestType' => $this->requestType,
            'ExpirePreauth' => $this->expirePreAuth,
            'Amount' => $this->amount,
            'CurrencyCode' => $this->currencyCode,
            'Installments' => $this->installments,
            'Bnpl' => $this->bnpl,
            'Parameters' => $this->parameters,
        ];
    }
}
