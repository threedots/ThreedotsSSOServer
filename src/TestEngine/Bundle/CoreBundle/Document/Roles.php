<?php

namespace TestEngine\Bundle\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\Document(repositoryClass="TestEngine\Bundle\CoreBundle\Repository\RolesRepository")
 */

class Roles
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Int
     */
    protected $role_id;


    /**
     * @MongoDB\String
     */
    protected $name;

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
     * @param mixed $role_id
     */
    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->role_id;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
}
