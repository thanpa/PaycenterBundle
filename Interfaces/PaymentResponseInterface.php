<?php

namespace Thanpa\PaycenterBundle\Interfaces;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface PaymentResponseInterface
 * @package Thanpa\PaycenterBundle\Interfaces
 */
interface PaymentResponseInterface
{
    /**
     * This action is called when a payment is successfully completed.
     *
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function successAction(Request $request);

    /**
     * This action is called when a payment is not completed.
     *
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function failAction(Request $request);

    /**
     * This action is called when a payment is cancelled.
     *
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function backlinkAction(Request $request);
}
