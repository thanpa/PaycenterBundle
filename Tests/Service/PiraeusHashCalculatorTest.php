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

        $expected = '551f158e669965f30bcfa65e558fd4aabb191d394de39be2adfab416575102d7';

        $this->assertEquals($expected, $class->calculate());
    }
}
