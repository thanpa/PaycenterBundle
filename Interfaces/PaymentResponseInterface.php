<?php

namespace Thanpa\PaycenterBundle\Interfaces;

/**
 * Interface PaymentResponseInterface
 * @package Thanpa\PaycenterBundle\Interfaces
 */
interface PaymentResponseInterface
{
    /**
     * This action is called when a payment is successfully completed.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function successAction();

    /**
     * This action is called when a payment is not completed.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function failAction();
}
