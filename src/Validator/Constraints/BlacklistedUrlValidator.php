<?php

namespace EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints;

use Doctrine\Common\Persistence\ObjectManager;
use EmanueleMinotto\UrlBlacklistBundle\Entity\Url;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validator for blacklisted URLs.
 */
class BlacklistedUrlValidator extends ConstraintValidator
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (empty(trim($value))) {
            return;
        }

        $entity = $this->objectManager->find(Url::class, $value);

        if ($entity instanceof Url) {
            $this->context->addViolation($constraint->message, [
                '%category%' => $entity->getCategory(),
                '%location%' => $entity->getLocation(),
                '%value%' => $value,
            ]);
        }
    }
}
