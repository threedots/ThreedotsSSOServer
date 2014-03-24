<?php

namespace TestEngine\Bundle\CoreBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;

class Base
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get($key)
    {
        return $this->container->get($key);
    }


}

