<?php

namespace TestEngine\Bundle\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\Document(repositoryClass="TestEngine\Bundle\CoreBundle\Repository\AccountRepository")
 */
class Account
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $userId;

    /**
     * @MongoDB\String
     */
    protected $packageId;

    /**
     * @MongoDB\Int
     */
    protected $currentNumberOfCompanies;

    /**
     * @MongoDB\Int
     */
    protected $currentNumberOfUsers;


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
     * Set packageId
     *
     * @param string $packageId
     * @return self
     */
    public function setPackageId($packageId)
    {
        $this->packageId = $packageId;
        return $this;
    }

    /**
     * Get packageId
     *
     * @return string $packageId
     */
    public function getPackageId()
    {
        return $this->packageId;
    }

    /**
     * Set currentNumberOfCompanies
     *
     * @param int $currentNumberOfCompanies
     * @return self
     */
    public function setCurrentNumberOfCompanies($currentNumberOfCompanies)
    {
        $this->currentNumberOfCompanies = $currentNumberOfCompanies;
        return $this;
    }

    /**
     * Get currentNumberOfCompanies
     *
     * @return int $currentNumberOfCompanies
     */
    public function getCurrentNumberOfCompanies()
    {
        return $this->currentNumberOfCompanies;
    }

    /**
     * Set currentNumberOfUsers
     *
     * @param int $currentNumberOfUsers
     * @return self
     */
    public function setCurrentNumberOfUsers($currentNumberOfUsers)
    {
        $this->currentNumberOfUsers = $currentNumberOfUsers;
        return $this;
    }

    /**
     * Get currentNumberOfUsers
     *
     * @return int $currentNumberOfUsers
     */
    public function getCurrentNumberOfUsers()
    {
        return $this->currentNumberOfUsers;
    }
}
