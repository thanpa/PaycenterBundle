<?php

namespace Thanpa\PaycenterBundle\Tests\Service;

use Thanpa\PaycenterBundle\Service\TicketIssuer;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

/**
 * Class TicketIssuerTest
 * @package Thanpa\PaycenterBundle\Tests\Service
 */
class TicketIssuerTest extends \PHPUnit_Framework_TestCase
{
    /** @var TicketIssuer */
    private $class;

    /** @var TicketIssuer */
    private $class2;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $mockFailedResponse = file_get_contents(__DIR__.'/../Fixtures/mockFailedResponse.xml');
        $mockSuccessResponse = file_get_contents(__DIR__.'/../Fixtures/mockSuccessResponse.xml');

        $mock = new MockHandler([new Response(200, [], $mockFailedResponse)]);
        $mock2 = new MockHandler([new Response(200, [], $mockSuccessResponse)]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $handler2 = HandlerStack::create($mock2);
        $client2 = new Client(['handler' => $handler2]);

        $this->class = new TicketIssuer(
            $client,
            '1',
            '2',
            '3',
            'username',
            'password',
            'https://paycenter.piraeusbank.gr/services/tickets/issuer.asmx'
        );

        $this->class2 = new TicketIssuer(
            $client2,
            '1',
            '2',
            '3',
            'username',
            'password',
            'https://paycenter.piraeusbank.gr/services/tickets/issuer.asmx'
        );
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage TicketIssuer failed: string
     */
    public function testGetTicketMethodResultCodeNotZero()
    {
        $this->class->getTicket();
    }

    public function testGetTicketMethodSuccessResult()
    {
        $this->assertEquals('1234567890', $this->class2->getTicket());
    }

    /**
     * @inheritdoc
     */
    public function tearDown()
    {
        $this->class = null;
        $this->class2 = null;
    }
}
