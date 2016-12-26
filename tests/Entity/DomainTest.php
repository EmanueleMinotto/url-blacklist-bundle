<?php

namespace EmanueleMinotto\UrlBlacklistBundle\Entity;

use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    /**
     * @var Domain
     */
    private $entity;

    protected function setUp()
    {
        $this->entity = new Domain();
    }

    public function testDomain()
    {
        $domain = 'test';

        $this->assertNull($this->entity->getDomain());

        $output = $this->entity->setDomain($domain);
        $this->assertNull($output);

        $this->assertSame($domain, $this->entity->getDomain());
    }

    public function testCategory()
    {
        $category = 'test';

        $this->assertNull($this->entity->getCategory());

        $output = $this->entity->setCategory($category);
        $this->assertNull($output);

        $this->assertSame($category, $this->entity->getCategory());
    }
}
