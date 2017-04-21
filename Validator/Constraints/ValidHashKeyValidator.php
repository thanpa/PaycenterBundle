<?php

namespace Thanpa\PaycenterBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Thanpa\PaycenterBundle\Entity\PaymentResponse;
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

    /** @var EntityManager */
    private $manager;

    /**
     * ValidHashKeyValidator constructor.
     * @param int           $posId      Pos Id
     * @param int           $acquirerId Acquirer Id
     * @param EntityManager $manager    Entity Manager
     */
    public function __construct($posId, $acquirerId, EntityManager $manager)
    {
        $this->posId = $posId;
        $this->acquirerId = $acquirerId;
        $this->manager = $manager;
    }

    /**
     * Validates hash key
     *
     * @param PaymentResponse         $protocol   Class to check hash key
     * @param Constraint|ValidHashKey $constraint Constraint
     * @throws \Exception if transaction ticket not found, or if request hash does not match calculated hash.
     */
    public function validate($protocol, Constraint $constraint)
    {
        $noHashResponseCodes = ['05', '12', '51', '34', '43', '54', '62', '92'];
        if (in_array($protocol->getResponseCode(), $noHashResponseCodes)) {
            return;
        }

        $transactionTicket = $this->manager
            ->getRepository('ThanpaPaycenterBundle:TransactionTicket')
            ->findOneBy(['merchantReference' => $protocol->getMerchantReference()]);

        if ($transactionTicket === null) {
            $this->context->buildViolation($constraint->message)->addViolation();
            return;
        }

        $calculator = new PiraeusHashCalculator(
            $transactionTicket->getTransactionTicket(),
            $this->posId,
            $this->acquirerId,
            $protocol->getMerchantReference(),
            $protocol->getApprovalCode(),
            $protocol->getParameters(),
            $protocol->getResponseCode(),
            $protocol->getSupportReferenceId(),
            $protocol->getAuthStatus(),
            $protocol->getPackageNo(),
            $protocol->getStatusFlag()
        );

        if ($protocol->getHashKey() !== $calculator->calculate()) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
