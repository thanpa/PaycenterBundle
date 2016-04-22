<?php

namespace Thanpa\PaycenterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PaymentResponseController
 * @package Thanpa\PaycenterBundle\Controller
 */
class PaymentResponseController extends Controller
{
    public function successAction()
    {
        // @todo
    }

    public function failAction()
    {
        // @todo
    }

    // @todo create a PaymentResponse form Type, add a transformer that will convert POST'ed data to a PaymentResponse object
}
