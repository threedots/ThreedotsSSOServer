<?php

namespace TestEngine\Bundle\CoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use TestEngine\Bundle\CoreBundle\Document\Roles;

/**
 * RolesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RolesRepository extends DocumentRepository
{

    public function addRole($data)
    {
        if ($data) {
            $role = $this->map($data);

            $this->dm->persist($role);
            $this->dm->flush();

            return $role;
        }

        return false;
    }

    protected function map($data)
    {
        $role = new Roles();

        if (isset($data['role_id'])) {
            $role->setRoleId($data['role_id']);
        }

        if (isset($data['name'])) {
            $role->setName($data['name']);
        }

        return $role;
    }

}