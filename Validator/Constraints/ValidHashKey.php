<?php

namespace Thanpa\PaycenterBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class ValidHashKey
 * @package Thanpa\PaycenterBundle\Validator\Constraints
 * @Annotation
 */
class ValidHashKey extends Constraint
{
    public $message = 'Given hash key does not match.';

    /**
     * @inheritdoc
     * @return string
     */
    public function validatedBy()
    {
        return 'thanpa_paycenter.validator_hash_key';
    }

    /**
     * @inheritdoc
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
