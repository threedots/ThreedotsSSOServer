<?php


namespace TestEngine\Bundle\SsoBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class Base
{
    /**
     * @param ContainerInterface $container
     */
    protected $container;

    protected $cookies;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->cookies   = Request::createFromGlobals()->cookies;
        $this->session   = $this->container->get('session');
    }

    /**
     * Returns true if the service id is defined.
     *
     * @param string $id The service id
     * @return Boolean true if the service id is defined, false otherwise
     */
    public function has($id)
    {
        return $this->container->has($id);
    }

    /**
     * Gets a service by id.
     *
     * @param string $id The service id
     * @return object The service
     */
    public function get($id)
    {
        return $this->container->get($id);
    }
}