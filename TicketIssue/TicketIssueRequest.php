<?php

namespace Thanpa\PaycenterBundle\TicketIssue;

/**
 * Class TicketIssueRequest
 * @package Thanpa\PaycenterBundle\TicketIssue
 */
class TicketIssueRequest
{
    /**
     * Builds XML needed for request to bank's SOAP Web Service
     *
     * @param array $fields Array containing field names and values to create Xml Fields
     * @return string
     */
    public static function getBody(array $fields)
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
