<?php

namespace Threedots\Bundle\SsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="sso_links")
 * @ORM\Entity(repositoryClass="Threedots\Bundle\SsoBundle\Entity\SsolinksRepository")
 */
class Ssolinks
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=100, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="links", type="string", length=100, nullable=false)
     */
    private $links;

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return string
     */
    public function getLinks()
    {
        return $this->links;
    }


}