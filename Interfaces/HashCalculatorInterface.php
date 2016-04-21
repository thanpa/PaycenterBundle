<?php

namespace Thanpa\PaycenterBundle\Interfaces;

/**
 * Interface HashCalculatorInterface
 * @package Thanpa\PaycenterBundle\Interfaces
 */
interface HashCalculatorInterface
{
    /**
     * Returns calculated hash key
     *
     * @return string
     */
    public function calculate();
}
