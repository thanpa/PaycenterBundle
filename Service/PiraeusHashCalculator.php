<?php

namespace Thanpa\PaycenterBundle\Service;

use Thanpa\PaycenterBundle\Interfaces\HashCalculatorInterface;

/**
 * Class PiraeusHashCalculator
 * @package Thanpa\PaycenterBundle\Service
 */
final class PiraeusHashCalculator implements HashCalculatorInterface
{
    /** @var string */
    private $transactionTicket;

    /** @var string */
    private $posId;

    /** @var string */
    private $acquirerId;

    /** @var string */
    private $merchantReference;

    /** @var string */
    private $approvalCode;

    /** @var string */
    private $parameters;

    /** @var string */
    private $responseCode;

    /** @var string */
    private $supportReferenceId;

    /** @var string */
    private $authStatus;

    /** @var string */
    private $packageNo;

    /** @var string */
    private $statusFlag;

    /**
     * PiraeusHashCalculator constructor.
     * @param string $transactionTicket  Transaction ticket
     * @param int $posId                 Pos Id
     * @param int $acquirerId            Acquirer Id
     * @param string $merchantReference  Merchant Reference
     * @param string $approvalCode       Approval Code
     * @param string $parameters         Parameters
     * @param string $responseCode       Response Code
     * @param string $supportReferenceId Support Reference Id
     * @param string $authStatus         Auth Status
     * @param string $packageNo          Package No
     * @param string $statusFlag         Status Flag
     */
    public function __construct(
        $transactionTicket,
        $posId,
        $acquirerId,
        $merchantReference,
        $approvalCode,
        $parameters,
        $responseCode,
        $supportReferenceId,
        $authStatus,
        $packageNo,
        $statusFlag)
    {
        $this->transactionTicket = $transactionTicket;
        $this->posId = $posId;
        $this->acquirerId = $acquirerId;
        $this->merchantReference = $merchantReference;
        $this->approvalCode = $approvalCode;
        $this->parameters = $parameters;
        $this->responseCode = $responseCode;
        $this->supportReferenceId = $supportReferenceId;
        $this->authStatus = $authStatus;
        $this->packageNo = $packageNo;
        $this->statusFlag = $statusFlag;
    }

    /**
     * Calculates hash key by concatenation of values, then uses sha256 algorithm.
     *
     * @return string
     */
    public function calculate()
    {
        $concatValues = sprintf(
            '%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s',
            $this->transactionTicket,
            $this->posId,
            $this->acquirerId,
            $this->merchantReference,
            $this->approvalCode,
            $this->parameters,
            $this->responseCode,
            $this->supportReferenceId,
            $this->authStatus,
            $this->packageNo,
            $this->statusFlag
        );

        return hash_hmac('sha256', $concatValues, $this->transactionTicket, false);
    }
}
