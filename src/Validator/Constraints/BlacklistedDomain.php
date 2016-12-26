<?php

namespace EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BlacklistedDomain extends Constraint
{
    /**
     * Validation message for blacklisted domains.
     *
     * @var string
     */
    public $message = 'This value is blacklisted (category "%category%").';
}
