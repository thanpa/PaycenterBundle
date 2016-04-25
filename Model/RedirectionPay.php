<?php

namespace Thanpa\PaycenterBundle\Model;

/**
 * Class RedirectionPay
 * @package Thanpa\PaycenterBundle\Model
 */
class RedirectionPay
{
    /** @var int */
    private $AcquirerId;

    /** @var int */
    private $MerchantId;

    /** @var int */
    private $PosId;

    /** @var string */
    private $User;

    /** @var string */
    private $LanguageCode;

    /** @var string */
    private $MerchantReference;

    /** @var string */
    private $ParamBackLink;

    /**
     * Get Acquirer Id
     *
     * @return int
     */
    public function getAcquirerId()
    {
        return $this->AcquirerId;
    }

    /**
     * Set Acquirer Id
     *
     * @param int $AcquirerId Acquirer Id
     * @return RedirectionPay
     */
    public function setAcquirerId($AcquirerId)
    {
        $this->AcquirerId = $AcquirerId;

        return $this;
    }

    /**
     * Get Merchant Id
     *
     * @return int
     */
    public function getMerchantId()
    {
        return $this->MerchantId;
    }

    /**
     * Set Merchant Id
     *
     * @param int $MerchantId Merchant Id
     * @return RedirectionPay
     */
    public function setMerchantId($MerchantId)
    {
        $this->MerchantId = $MerchantId;

        return $this;
    }

    /**
     * Get Pos Id
     *
     * @return int
     */
    public function getPosId()
    {
        return $this->PosId;
    }

    /**
     * Set Pos Id
     *
     * @param int $PosId Pos Id
     * @return RedirectionPay
     */
    public function setPosId($PosId)
    {
        $this->PosId = $PosId;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * Set user
     *
     * @param string $User User
     * @return RedirectionPay
     */
    public function setUser($User)
    {
        $this->User = $User;

        return $this;
    }

    /**
     * Get language code
     *
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->LanguageCode;
    }

    /**
     * Set language code
     *
     * @param string $LanguageCode Language Code
     * @return RedirectionPay
     */
    public function setLanguageCode($LanguageCode)
    {
        $this->LanguageCode = $LanguageCode;

        return $this;
    }

    /**
     * Get merchant reference
     *
     * @return string
     */
    public function getMerchantReference()
    {
        return $this->MerchantReference;
    }

    /**
     * Set Merchant Reference
     *
     * @param string $MerchantReference Merchant Reference
     * @return RedirectionPay
     */
    public function setMerchantReference($MerchantReference)
    {
        $this->MerchantReference = $MerchantReference;

        return $this;
    }

    /**
     * Get Param Back link
     *
     * @return string
     */
    public function getParamBackLink()
    {
        return $this->ParamBackLink;
    }

    /**
     * Set Param Back Link
     *
     * @param string $ParamBackLink Param Back Link
     * @throws \Exception if ? character is passed in $ParamBackLink
     * @return RedirectionPay
     */
    public function setParamBackLink($ParamBackLink)
    {
        if (strstr($ParamBackLink, '?')) {
            throw new \Exception('ParamBackLink should not have a ? character.');
        }

        $this->ParamBackLink = $ParamBackLink;

        return $this;
    }
}
