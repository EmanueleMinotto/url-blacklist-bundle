<?php

namespace EmanueleMinotto\UrlBlacklistBundle\DependencyInjection;

use EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints\BlacklistedDomainValidator;
use EmanueleMinotto\UrlBlacklistBundle\Validator\Constraints\BlacklistedUrlValidator;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class UrlBlacklistExtensionTest extends AbstractExtensionTestCase
{
    public function testServices()
    {
        $this->load();

        $this->assertContainerBuilderHasService(
            'url_blacklist.blacklisted_domain',
            BlacklistedDomainValidator::class
        );
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'url_blacklist.blacklisted_domain',
            'validator.constraint_validator'
        );

        $this->assertContainerBuilderHasService(
            'url_blacklist.blacklisted_url',
            BlacklistedUrlValidator::class
        );
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'url_blacklist.blacklisted_url',
            'validator.constraint_validator'
        );
    }

    protected function getContainerExtensions()
    {
        return [
            new UrlBlacklistExtension(),
        ];
    }
}
