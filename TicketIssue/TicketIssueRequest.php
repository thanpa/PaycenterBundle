<?php

namespace Thanpa\PaycenterBundle\TicketIssue;

use Thanpa\PaycenterBundle\Service\TicketIssuer;

/**
 * Class TicketIssueRequest
 * @package Thanpa\PaycenterBundle\TicketIssue
 */
class TicketIssueRequest
{
    /**
     * Builds XML needed for request to bank's SOAP Web Service
     *
     * @param TicketIssuer $issuer Ticket Issuer object
     * @return string
     */
    public static function getBody(TicketIssuer $issuer)
    {
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'utf-8');
        $writer->setIndent(true);

        $writer->startElement('soap12:Envelope');

        $writer->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $writer->writeAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        $writer->writeAttribute('xmlns:soap12', 'http://www.w3.org/2003/05/soap-envelope');

        $writer->startElement('soap12:Body');
        $writer->startElement('IssueNewTicket');
        $writer->writeAttribute('xmlns', 'http://piraeusbank.gr/paycenter/redirection');

        $writer->startElement('Request');

        $fields = [
            'Username' => $issuer->getUsername(),
            'Password' => $issuer->getPassword(),
            'MerchantId' => $issuer->getMerchantId(),
            'PosId' => $issuer->getPosId(),
            'AcquirerId' => $issuer->getAcquirerId(),
            'MerchantReference' => $issuer->getMerchantReference(),
            'RequestType' => $issuer->getRequestType(),
            'ExpirePreauth' => $issuer->getExpirePreAuth(),
            'Amount' => $issuer->getAmount(),
            'CurrencyCode' => $issuer->getCurrencyCode(),
            'Installments' => $issuer->getInstallments(),
            'Bnpl' => $issuer->getBnpl(),
            'Parameters' => $issuer->getParameters(),
        ];

        foreach ($fields as $field => $value) {
            $writer->startElement($field);
            $writer->text($value);
            $writer->endElement();
        }

        $writer->endElement(); // end Request

        $writer->endElement(); // end IssueNewTicket
        $writer->endElement(); // end soap12:Body

        $writer->endElement(); // end soap12:Envelope

        return $writer->flush(true);
    }
}
