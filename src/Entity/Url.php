<?php

namespace EmanueleMinotto\UrlBlacklistBundle\Entity;

/**
 * Blacklisted URL.
 */
class Url
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $category;

    /**
     * Set locations.
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get locations.
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set category.
     *
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Get category.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
}
