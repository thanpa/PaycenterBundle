<?php

namespace Thanpa\PaycenterBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Thanpa\PaycenterBundle\Entity\PaymentResponse as PaymentResponseEntity;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PaymentResponse
 * @package Thanpa\PaycenterBundle\Service
 */
final class PaymentResponse
{
    /**
     * PaymentResponse constructor.
     *
     * @param EntityManagerInterface $manager Entity manager
     * @param ValidatorInterface $validator Validator
     * @return null
     */
    public function __construct(EntityManagerInterface $manager, ValidatorInterface $validator)
    {
        $this->manager = $manager;
        $this->validator = $validator;
    }

    /**
     * Extracts a payment response from the current request, saves it in the db and returns it.
     *
     * @return PaymentResponse
     */
    public function extract(Request $request)
    {
        $paymentResponse = new PaymentResponseEntity();
        $paymentResponse
            ->setSupportReferenceId((int) $request->get('SupportReferenceID'))
            ->setResultCode($request->get('ResultCode'))
            ->setResultDescription($request->get('ResultDescription'))
            ->setStatusFlag($request->get('StatusFlag'))
            ->setResponseCode($request->get('ResponseCode'))
            ->setResponseDescription($request->get('ResponseDescription'))
            ->setLanguageCode($request->get('LanguageCode'))
            ->setMerchantReference($request->get('MerchantReference'))
            ->setTransactionDateTime($request->get('TransactionDateTime'))
            ->setTransactionId((int) $request->get('TransactionId'))
            ->setCardType((int) $request->get('CardType'))
            ->setPackageNo((int) $request->get('PackageNo'))
            ->setApprovalCode($request->get('ApprovalCode'))
            ->setRetrievalRef($request->get('RetrievalRef'))
            ->setAuthStatus($request->get('AuthStatus'))
            ->setParameters($request->get('Parameters'))
            ->setHashKey($request->get('HashKey'));

        $errors = $this->validator->validate($paymentResponse);
        if (count($errors) > 0) {
            $textErrors = [];
            foreach ($errors as $error) {
                $textErrors[] = sprintf('%s: %s', $error->getPropertyPath(), $error->getMessage());
            }
            throw new \Exception(implode(', ', $textErrors));
        }

        $this->manager->persist($paymentResponse);
        $this->manager->flush();

        return $paymentResponse;
    }

    public function getDisplayMessage(PaymentResponseEntity $paymentResponse)
    {
        $message = $paymentResponse->getResultDescription();
        if (empty($message)) {
            $messages = [
                '00' => 'Completed successfully',
                '08' => 'Completed successfully',
                '10' => 'Completed successfully',
                '16' => 'Completed successfully',
                '11' => 'Transaction already processed',
                '05' => 'Declined',
                '12' => 'Declined',
                '51' => 'Declined',
                '34' => 'Lost card / Stolen card / Pick up',
                '43' => 'Lost card / Stolen card / Pick up',
                '54' => 'Expired card',
                '62' => 'Restricted Card',
                '92' => 'Declined',
            ];
            $message = $messages[$paymentResponse->getResponseCode()];
        }
        return $message;
    }
}
