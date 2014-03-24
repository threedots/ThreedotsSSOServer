<?php

namespace Threedots\Bundle\SsoBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class SsolinksRepository extends EntityRepository
{
    public function getBySSOCode($ssoCode)
    {
        $sql = "SELECT * FROM sso_links WHERE code = '" . $ssoCode . "'";
        $record = $this->getEntityManager()->getConnection()->query($sql)->fetchAll();

        return $record ? $record[0] : '';
    }

    public function insertSsoSessionId($sessionId, $link)
    {
        $sql = "INSERT INTO `sso_links`(`code`, `link`) VALUES('" . $sessionId . "', '" . $link . "')";

        return $this->getEntityManager()->getConnection()->query($sql);
    }

    public function updateSsoSessionId($sessionId, $link)
    {
        $sql = "UPDATE `sso_links` SET `link` = '" . $link . "' WHERE `code` = '" . $sessionId . "'";

        return $this->getEntityManager()->getConnection()->query($sql);
    }

    public function removeSSOLinks()
    {
        $sql = "TRUNCATE sso_links";
        return $this->getEntityManager()->getConnection()->query($sql);
    }
}