<?php

namespace EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BlacklistedUrl extends Constraint
{
    /**
     * Validation message for blacklisted URLs.
     *
     * @var string
     */
    public $message = 'This value is blacklisted (category "%category%").';
}
