<?php

namespace Thanpa\PaycenterBundle\Service;

use Thanpa\PaycenterBundle\Interfaces\HashCalculatorInterface;

/**
 * Class PiraeusHashCalculator
 * @package Thanpa\PaycenterBundle\Service
 */
class PiraeusHashCalculator implements HashCalculatorInterface
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
     * Get Status Flag
     *
     * @return string
     */
    public function getStatusFlag()
    {
        return $this->statusFlag;
    }

    /**
     * Set Status Flag
     *
     * @param string $statusFlag Status Flag
     * @return PiraeusHashCalculator
     */
    public function setStatusFlag($statusFlag)
    {
        $this->statusFlag = $statusFlag;

        return $this;
    }

    /**
     * Get Package No
     *
     * @return string
     */
    public function getPackageNo()
    {
        return $this->packageNo;
    }

    /**
     * Set Package No
     *
     * @param string $packageNo Package No
     * @return PiraeusHashCalculator
     */
    public function setPackageNo($packageNo)
    {
        $this->packageNo = $packageNo;

        return $this;
    }

    /**
     * Get auth status
     *
     * @return string
     */
    public function getAuthStatus()
    {
        return $this->authStatus;
    }

    /**
     * Set Auth status
     *
     * @param string $authStatus Auth Status
     * @return PiraeusHashCalculator
     */
    public function setAuthStatus($authStatus)
    {
        $this->authStatus = $authStatus;

        return $this;
    }

    /**
     * Get support reference Id
     *
     * @return string
     */
    public function getSupportReferenceId()
    {
        return $this->supportReferenceId;
    }

    /**
     * Set support Reference Id
     *
     * @param string $supportReferenceId Support Reference Id
     * @return PiraeusHashCalculator
     */
    public function setSupportReferenceId($supportReferenceId)
    {
        $this->supportReferenceId = $supportReferenceId;

        return $this;
    }

    /**
     * Get response code
     *
     * @return string
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Set response code
     *
     * @param string $responseCode Response Code
     * @return PiraeusHashCalculator
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return string
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set Parameters
     *
     * @param string $parameters Parameters
     * @return PiraeusHashCalculator
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get approval code
     *
     * @return string
     */
    public function getApprovalCode()
    {
        return $this->approvalCode;
    }

    /**
     * Set approval code
     *
     * @param string $approvalCode Approval code
     * @return PiraeusHashCalculator
     */
    public function setApprovalCode($approvalCode)
    {
        $this->approvalCode = $approvalCode;

        return $this;
    }

    /**
     * Get merchant reference
     *
     * @return string
     */
    public function getMerchantReference()
    {
        return $this->merchantReference;
    }

    /**
     * Set Merchant reference
     *
     * @param string $merchantReference Merchant Reference
     * @return PiraeusHashCalculator
     */
    public function setMerchantReference($merchantReference)
    {
        $this->merchantReference = $merchantReference;

        return $this;
    }

    /**
     * Get Acquirer Id
     *
     * @return string
     */
    public function getAcquirerId()
    {
        return $this->acquirerId;
    }

    /**
     * Set Acquirer Id
     *
     * @param string $acquirerId Acquirer Id
     * @return PiraeusHashCalculator
     */
    public function setAcquirerId($acquirerId)
    {
        $this->acquirerId = $acquirerId;

        return $this;
    }

    /**
     * Get Pos Id
     *
     * @return string
     */
    public function getPosId()
    {
        return $this->posId;
    }

    /**
     * Set post id
     *
     * @param string $posId Pos Id
     * @return PiraeusHashCalculator
     */
    public function setPosId($posId)
    {
        $this->posId = $posId;

        return $this;
    }

    /**
     * Get transaction ticket
     *
     * @return string
     */
    public function getTransactionTicket()
    {
        return $this->transactionTicket;
    }

    /**
     * Set transaction ticket
     *
     * @param string $transactionTicket Transaction Ticket
     * @return PiraeusHashCalculator
     */
    public function setTransactionTicket($transactionTicket)
    {
        $this->transactionTicket = $transactionTicket;

        return $this;
    }

    /**
     * Calculates hash key by concatenation of values, then uses sha256 algorithm.
     *
     * @return string
     */
    public function calculate()
    {
        $concatValues = sprintf(
            '%s%s%s%s%s%s%s%s%s%s%s',
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

        return strtoupper(hash('sha256', $concatValues, false));
    }
}
