<?php

namespace Thanpa\PaycenterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Thanpa\PaycenterBundle\Form\Type\PaymentResponseType;

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

    /**
     * Converts POST'ed data to PaymentResponse object.
     *
     * @param RequestStack $requestStack Request Stack
     * @return \Thanpa\PaycenterBundle\Model\PaymentResponse
     * @throws \Exception if form has errors or hash key is invalid
     */
    protected function convertPostToPaymentResponse(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();

        $form = $this->createForm(PaymentResponseType::class);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            return $form->getData();
        }

        throw new \Exception('Form is not valid or not submitted');
    }
}
