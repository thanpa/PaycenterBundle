<?php

namespace Thanpa\PaycenterBundle\Tests\Service;

use Thanpa\PaycenterBundle\Service\PiraeusHashCalculator;

/**
 * Class PiraeusHashCalculatorTest
 * @package Thanpa\PaycenterBundle\Tests\Service
 */
class PiraeusHashCalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCalculateMethod()
    {
        $class = new PiraeusHashCalculator(
            '4236ece6142b4639925eb6f80217122f',
            '99999999',
            '14',
            'Test',
            '389700',
            'MyParam',
            '00',
            '364629',
            '02',
            '1',
            'Success'
        );

        $expected = 'CC60B1B8445EA0B1759ECFB42E7DE2BF8A280247889F8BF38842045298C57556';

        $this->assertEquals($expected, $class->calculate());
    }
}
