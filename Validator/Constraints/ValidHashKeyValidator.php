<?php

namespace Thanpa\PaycenterBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
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
        $transactionTicket = $this->getTransactionTicketByMerchantReference($protocol->getMerchantReference());

        $calculator = new PiraeusHashCalculator(
            $transactionTicket,
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
            throw new \Exception($constraint->message);
        }
    }

    /**
     * Get transaction ticket by merchant reference
     *
     * @param string $merchantReference Merchant Reference
     * @return string Transaction Ticket
     * @throws \Exception if transaction ticket is not found
     */
    private function getTransactionTicketByMerchantReference($merchantReference)
    {
        $result = $this->manager
            ->getRepository('ThanpaPaycenterBundle:TransactionTicket')
            ->findOneBy(['merchantReference' => $merchantReference]);

        if ($result === null) {
            throw new \Exception('TransactionTicket not found in database for this request.');
        }

        return $result->getTransactionTicket();
    }
}
