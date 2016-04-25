<?php

namespace Thanpa\PaycenterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Thanpa\PaycenterBundle\Form\Type\PaymentResponseType;
use Thanpa\PaycenterBundle\Interfaces\PaymentResponseInterface;

/**
 * Class AbstractPaymentResponseController
 * @package Thanpa\PaycenterBundle\Controller
 */
abstract class AbstractPaymentResponseController extends Controller implements PaymentResponseInterface
{
    /**
     * Converts POST'ed data to PaymentResponse object.
     *
     * @return \Thanpa\PaycenterBundle\Model\PaymentResponse
     * @throws \Exception if form has errors or hash key is invalid
     */
    protected function convertPostToPaymentResponse()
    {
        $form = $this->createForm(PaymentResponseType::class);
        $form->submit($_POST);

        if ($form->isValid() && $form->isSubmitted()) {
            return $form->getData();
        }

        throw new \Exception('Form is not valid or not submitted');
    }
}
