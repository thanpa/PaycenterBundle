<?php

namespace Thanpa\PaycenterBundle\Tests\Model;
use Thanpa\PaycenterBundle\Model\RedirectionPay;

/**
 * Class RedirectionPayTest
 * @package Thanpa\PaycenterBundle\Tests\Model
 */
class RedirectionPayTest extends \PHPUnit_Framework_TestCase
{
    /** @var RedirectionPay */
    private $class;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->class = new RedirectionPay();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage ParamBackLink should not have a ? character.
     */
    public function testParamBackLinkWithQuestionMark()
    {
        $this->class->setParamBackLink('?param1=true');
    }

    public function testParamBackLinkWithoutQuestionMark()
    {
        $paramString = 'p1=true&p2=false';

        $this->class->setParamBackLink($paramString);
        $this->assertEquals($paramString, $this->class->getParamBackLink());
    }

    /**
     * @inheritdoc
     */
    public function tearDown()
    {
        $this->class = null;
    }
}
