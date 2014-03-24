<?php

namespace TestEngine\Bundle\CoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use TestEngine\Bundle\CoreBundle\Document\CompanyUsers;

/**
 * CompanyUsersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompanyUsersRepository extends DocumentRepository
{
    public function addCompanyUser($data)
    {
        if ($data) {
            $obj = $this->map($data);

            $this->dm->persist($obj);
            $this->dm->flush();

            return $obj;
        }

        return false;
    }

    protected function map($data)
    {
        $document = new CompanyUsers();

        if (isset($data['user_name'])) {
            $document->setUserName($data['user_name']);
        }

        if (isset($data['password'])) {
            $document->setPassword($data['password']);
        }

        if (isset($data['is_account_admin'])) {
            $document->setIsAccountAdmin($data['is_account_admin']);
        }

        return $document;
    }



    public function getInfo($userName, $password)
    {
        $result = $this->dm->getRepository('TestEngineCoreBundle:CompanyUsers')
                           ->findBy(
                                array('userName' => $userName, 'password' => $password)
                            );

        return $result ? $result[0] : false;
    }
}