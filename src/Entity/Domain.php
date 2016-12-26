<?php

namespace EmanueleMinotto\UrlBlacklistBundle\Entity;

/**
 * Blacklisted domain.
 */
class Domain
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $category;

    /**
     * Set domain.
     *
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Get domain.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
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
