<?php

namespace TestEngine\Bundle\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\Document(repositoryClass="TestEngine\Bundle\CoreBundle\Repository\PackagesRepository")
 */
class Packages
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $title;

    /**
     * @MongoDB\String
     */
    protected $roles;

    /**
     * @MongoDB\Int
     */
    protected $limitCompanyCount;

    /**
     * @MongoDB\Int
     */
    protected $limitUserCount;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set roles
     *
     * @param string $roles
     * @return self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Get roles
     *
     * @return string $roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set limitCompanyCount
     *
     * @param int $limitCompanyCount
     * @return self
     */
    public function setLimitCompanyCount($limitCompanyCount)
    {
        $this->limitCompanyCount = $limitCompanyCount;
        return $this;
    }

    /**
     * Get limitCompanyCount
     *
     * @return int $limitCompanyCount
     */
    public function getLimitCompanyCount()
    {
        return $this->limitCompanyCount;
    }

    /**
     * Set limitUserCount
     *
     * @param int $limitUserCount
     * @return self
     */
    public function setLimitUserCount($limitUserCount)
    {
        $this->limitUserCount = $limitUserCount;
        return $this;
    }

    /**
     * Get limitUserCount
     *
     * @return int $limitUserCount
     */
    public function getLimitUserCount()
    {
        return $this->limitUserCount;
    }
}
