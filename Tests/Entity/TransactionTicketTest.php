<?php

namespace Thanpa\PaycenterBundle\Tests\Entity;

use Thanpa\PaycenterBundle\Entity\TransactionTicket;

/**
 * Class TransactionTicketTest
 * @package Thanpa\PaycenterBundle\Tests\Entity
 */
class TransactionTicketTest extends \PHPUnit_Framework_TestCase
{
    public function testSetAndGetValues()
    {
        $merchantReference = '123456';
        $transactionTicket = '0395046GDG';

        $class = new TransactionTicket($merchantReference, $transactionTicket);

        $this->assertEquals($class->getMerchantReference(), $merchantReference);
        $this->assertEquals($class->getTransactionTicket(), $transactionTicket);
    }
}
