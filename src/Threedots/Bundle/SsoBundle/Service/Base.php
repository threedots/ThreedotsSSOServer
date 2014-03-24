<?php

/*
 * This file is part of the falgun phantom bundle.
 *
 * (c) Threedots.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Threedots\Bundle\SsoBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Base
 * @package Threedots\Bundle\SsoBundle\Service
 */
class Base
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $key
     * @return object
     */
    public function get($key)
    {
        return $this->container->get($key);
    }
}