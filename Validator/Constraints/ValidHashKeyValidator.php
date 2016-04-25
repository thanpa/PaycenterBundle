<?php

namespace Thanpa\PaycenterBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Thanpa\PaycenterBundle\Model\PaymentResponse;
use Thanpa\PaycenterBundle\Service\PiraeusHashCalculator;

/**
 * Class ValidHashKeyValidator
 * @package Thanpa\PaycenterBundle\Validator\Constraints
 */
class ValidHashKeyValidator extends ConstraintValidator
{
    /** @var int */
    private $posId;

    /** @var int */
    private $acquirerId;

    /**
     * ValidHashKeyValidator constructor.
     * @param int $posId      Pos Id
     * @param int $acquirerId Acquirer Id
     */
    public function __construct($posId, $acquirerId)
    {
        $this->posId = $posId;
        $this->acquirerId = $acquirerId;
    }

    /**
     * Validates hash key
     *
     * @param PaymentResponse         $protocol   Class to check hash key
     * @param Constraint|ValidHashKey $constraint Constraint
     */
    public function validate($protocol, Constraint $constraint)
    {
        $calculator = new PiraeusHashCalculator();
        $calculator
            ->setTransactionTicket('') // @todo create new entity to get MerchantReference, and TransactionTicket
            ->setPosId($this->posId)
            ->setAcquirerId($this->acquirerId)
            ->setMerchantReference($protocol->getMerchantReference())
            ->setApprovalCode($protocol->getApprovalCode())
            ->setParameters($protocol->getParameters())
            ->setResponseCode($protocol->getResponseCode())
            ->setSupportReferenceId($protocol->getSupportReferenceId())
            ->setAuthStatus($protocol->getAuthStatus())
            ->setPackageNo($protocol->getPackageNo())
            ->setStatusFlag($protocol->getStatusFlag());

        if ($protocol->getHashKey() !== $calculator->calculate()) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
