<?php

namespace TestEngine\Bundle\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\Document(repositoryClass="TestEngine\Bundle\CoreBundle\Repository\CompanyUserPermissionsRepository")
 */
class CompanyUserPermissions
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $companyId;

    /**
     * @MongoDB\String
     */
    protected $userId;

    /**
     * @MongoDB\String
     */
    protected $roles;


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
     * Set companyId
     *
     * @param string $companyId
     * @return self
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
        return $this;
    }

    /**
     * Get companyId
     *
     * @return string $companyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get userId
     *
     * @return string $userId
     */
    public function getUserId()
    {
        return $this->userId;
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
}
