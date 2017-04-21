<?php

namespace Thanpa\PaycenterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RedirectionPayController
 * @package Thanpa\PaycenterBundle\Controller
 */
class RedirectionPayController extends Controller
{
    /**
     * Shows a form with hidden form fields and sends request to bank's payment service.
     *
     * @param Request $request The request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectToBankAction(Request $request)
    {
        return $this->render(
            'ThanpaPaycenterBundle:RedirectionPay:redirect.html.twig',
            [
                'acquirerId' => $this->getParameter('thanpa_paycenter.acquirerId'),
                'merchantId' => $this->getParameter('thanpa_paycenter.merchantId'),
                'posId' => $this->getParameter('thanpa_paycenter.posId'),
                'username' => $this->getParameter('thanpa_paycenter.username'),
                'languageCode' => $request->get('languageCode', 'en-US'),
                'merchantReference' => $request->get('merchantReference', ''),
                'paramBackLink' => $this->getParameter('thanpa_paycenter.param_back_link'),
                'redirectionPayUrl' => $this->getParameter('thanpa_paycenter.redirection_pay_url'),
            ]
        );
    }
}
