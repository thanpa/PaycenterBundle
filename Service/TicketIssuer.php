<?php

namespace Thanpa\PaycenterBundle\Service;

use GuzzleHttp\Client;
use Thanpa\PaycenterBundle\TicketIssue\TicketIssueRequest;

/**
 * Class TicketIssuer
 * @package Thanpa\PaycenterBundle\Service
 */
class TicketIssuer
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
    private $requestType = 02;

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

    /**
     * TicketIssuer constructor.
     * @param Client $client     Guzzle Client
     * @param int    $acquirerId Acquirer Id
     * @param int    $merchantId Merchant Id
     * @param int    $posId      Pos Id
     * @param string $username   Username
     * @param string $password   Password
     * @param string $url        Url
     */
    public function __construct(Client $client, $acquirerId, $merchantId, $posId, $username, $password, $url)
    {
        $this->client = $client;
        $this->acquirerId = $acquirerId;
        $this->merchantId = $merchantId;
        $this->posId = $posId;
        $this->username = $username;
        $this->password = $password;
        $this->url = $url;
    }

    /**
     * Get Acquirer Id
     *
     * @return int
     */
    public function getAcquirerId()
    {
        return $this->acquirerId;
    }

    /**
     * Set AcquirerId
     *
     * @param int $acquirerId Acquirer Id
     * @return TicketIssuer
     */
    public function setAcquirerId($acquirerId)
    {
        $this->acquirerId = $acquirerId;

        return $this;
    }

    /**
     * Get merchant id
     *
     * @return int
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * Set merchant id
     *
     * @param int $merchantId Merchant id
     * @return TicketIssuer
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * Get Pos id
     *
     * @return int
     */
    public function getPosId()
    {
        return $this->posId;
    }

    /**
     * Set Pos Id
     *
     * @param int $posId Pos Id
     * @return TicketIssuer
     */
    public function setPosId($posId)
    {
        $this->posId = $posId;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username Username
     * @return TicketIssuer
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
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
     * Set password
     *
     * @param string $password Password
     * @return TicketIssuer
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get request type
     *
     * @return string
     */
    public function getRequestType()
    {
        return $this->requestType;
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
     * Get currency code
     * @return int
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
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
     * Get Merchant Reference
     *
     * @return string
     */
    public function getMerchantReference()
    {
        return $this->merchantReference;
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
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
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
     * Get installments
     *
     * @return int
     */
    public function getInstallments()
    {
        return $this->installments;
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
     * Get Expire Pre Auth
     *
     * @return string
     */
    public function getExpirePreAuth()
    {
        return $this->expirePreAuth;
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
     * Get Bnpl
     *
     * @return int
     */
    public function getBnpl()
    {
        return $this->bnpl;
    }

    /**
     * Set Bnpl
     *
     * @param int $bnpl Bnpl
     * @return TicketIssuer
     */
    public function setBnpl($bnpl)
    {
        $this->bnpl = $bnpl;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return string
     */
    public function getParameters()
    {
        return $this->parameters;
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
     * @throws \Exception If Transaction Ticket system does not return a valid response
     */
    public function getTicket()
    {
        $response = $this->client->post($this->url, [
            'body' => TicketIssueRequest::getBody($this),
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

        return $xpath->query(sprintf($nodeXPath, 'TranTicket'))->item(0)->nodeValue;
    }
}
