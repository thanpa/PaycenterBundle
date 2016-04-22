<?php

namespace Thanpa\PaycenterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Thanpa\PaycenterBundle\Model\RedirectionPay;

/**
 * Class RedirectionPayController
 * @package Thanpa\PaycenterBundle\Controller
 */
class RedirectionPayController extends Controller
{
    /**
     * Shows a form with hidden form fields and sends request to bank's payment service.
     *
     * @param string $languageCode      Language code
     * @param string $merchantReference Merchant Reference
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectToBankAction($languageCode, $merchantReference)
    {
        $cancelRouteName = $this->getParameter('thanpa_paycenter.cancelLink');

        $redirectionPay = new RedirectionPay();
        $redirectionPay
            ->setAcquirerId($this->getParameter('thanpa_paycenter.acquirerId'))
            ->setMerchantId($this->getParameter('thanpa_paycenter.merchantId'))
            ->setPosId($this->getParameter('thanpa_paycenter.posId'))
            ->setUser($this->getParameter('thanpa_paycenter.username'))
            ->setLanguageCode($languageCode)
            ->setMerchantReference($merchantReference)
            ->setParamBackLink($this->generateUrl($cancelRouteName, [], UrlGeneratorInterface::ABSOLUTE_URL));

        $form = $this->createForm('Thanpa\\PaycenterBundle\\Form\\Type\\RedirectionPayType', $redirectionPay, [
            'action' => $this->getParameter('thanpa_paycenter.redirection_pay_url'),
        ]);

        return $this->render('ThanpaPaycenterBundle:RedirectionPay:redirect.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
