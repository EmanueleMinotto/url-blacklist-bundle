<?php

namespace EmanueleMinotto\UrlBlacklistBundle\Entity;

use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    /**
     * @var Url
     */
    private $entity;

    protected function setUp()
    {
        $this->entity = new Url();
    }

    public function testLocation()
    {
        $location = 'http://www.example.com';

        $this->assertNull($this->entity->getLocation());

        $output = $this->entity->setLocation($location);
        $this->assertNull($output);

        $this->assertSame($location, $this->entity->getLocation());
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
