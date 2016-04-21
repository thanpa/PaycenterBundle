<?php

namespace Thanpa\PaycenterBundle\Tests\Service;

use Thanpa\PaycenterBundle\Service\PiraeusHashCalculator;

/**
 * Class PiraeusHashCalculatorTest
 * @package Thanpa\PaycenterBundle\Tests\Service
 */
class PiraeusHashCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var PiraeusHashCalculator */
    private $class;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->class = new PiraeusHashCalculator();
    }

    public function testCalculateMethod()
    {
        $class = $this->class;
        $class
            ->setTransactionTicket('4236ece6142b4639925eb6f80217122f')
            ->setPosId('99999999')
            ->setAcquirerId('14')
            ->setMerchantReference('Test')
            ->setApprovalCode('389700')
            ->setParameters('MyParam')
            ->setResponseCode('00')
            ->setSupportReferenceId('364629')
            ->setAuthStatus('02')
            ->setPackageNo('1')
            ->setStatusFlag('Success');

        $expected = 'CC60B1B8445EA0B1759ECFB42E7DE2BF8A280247889F8BF38842045298C57556';

        $this->assertEquals($expected, $class->calculate());
    }

    /**
     * @inheritdoc
     */
    public function tearDown()
    {
        $this->class = null;
    }
}
