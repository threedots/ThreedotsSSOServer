<?php

namespace TestEngine\Bundle\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\Document(repositoryClass="TestEngine\Bundle\CoreBundle\Repository\CompanyUsersRepository")
 */
class CompanyUsers
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $userName;

    /**
     * @MongoDB\String
     */
    protected $password;

    /**
     * @MongoDB\Boolean
     */
    protected $isAccountAdmin;


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
     * Set userName
     *
     * @param string $userName
     * @return self
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * Get userName
     *
     * @return string $userName
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set isAccountAdmin
     *
     * @param boolean $isAccountAdmin
     * @return self
     */
    public function setIsAccountAdmin($isAccountAdmin)
    {
        $this->isAccountAdmin = $isAccountAdmin;
        return $this;
    }

    /**
     * Get isAccountAdmin
     *
     * @return boolean $isAccountAdmin
     */
    public function getIsAccountAdmin()
    {
        return $this->isAccountAdmin;
    }
}
