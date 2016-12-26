<?php

namespace EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints;

use Doctrine\Common\Persistence\ObjectManager;
use EmanueleMinotto\UrlBlacklistBundle\Entity\Domain;
use Exception;
use Pdp\Parser;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validator for blacklisted domains.
 */
class BlacklistedDomainValidator extends ConstraintValidator
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * Host or URL parser.
     *
     * @var Parser
     */
    private $parser;

    /**
     * @param ObjectManager $objectManager
     * @param Parser        $parser
     */
    public function __construct(ObjectManager $objectManager, Parser $parser)
    {
        $this->objectManager = $objectManager;
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (empty(trim($value))) {
            return;
        }

        try {
            $parsed = $this->parser->parseUrl($value);
        } catch (Exception $exception) {
            return;
        }

        $entity = $this->objectManager
            ->getRepository(Domain::class)
            ->findOneBy([
                'domain' => [
                    $parsed->host->publicSuffix,
                    $parsed->host->registerableDomain,
                    $parsed->host->host,
                ],
            ]);

        if ($entity instanceof Domain) {
            $this->context->addViolation($constraint->message, [
                '%category%' => $entity->getCategory(),
                '%domain%' => $entity->getDomain(),
                '%value%' => $value,
            ]);
        }
    }
}
