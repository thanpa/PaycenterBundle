<?php

namespace Thanpa\PaycenterBundle\Interfaces;

/**
 * Interface TicketIssuerInterface
 * @package Thanpa\PaycenterBundle\Interfaces
 */
interface TicketIssuerInterface
{
    /**
     * Makes a request to ticket issuer mechanism to get a transaction ticket
     *
     * @return string Transaction Ticket returned from bank
     */
    public function getTicket();
}
