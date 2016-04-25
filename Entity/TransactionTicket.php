<?php

namespace Thanpa\PaycenterBundle\Entity;

/**
 * Class TransactionTicket
 * @package Thanpa\PaycenterBundle\Entity
 */
class TransactionTicket
{
    /** @var string */
    protected $id;

    /** @var string */
    private $merchantReference;

    /** @var string */
    private $transactionTicket;

    /**
     * TransactionTicket constructor.
     * @param string $merchantReference Merchant Reference
     * @param string $transactionTicket Transaction Ticket
     */
    public function __construct($merchantReference, $transactionTicket)
    {
        $this->merchantReference = $merchantReference;
        $this->transactionTicket = $transactionTicket;
    }

    /**
     * Get merchant reference
     *
     * @return string
     */
    public function getMerchantReference()
    {
        return $this->merchantReference;
    }

    /**
     * Get transaction ticket
     *
     * @return string
     */
    public function getTransactionTicket()
    {
        return $this->transactionTicket;
    }
}
