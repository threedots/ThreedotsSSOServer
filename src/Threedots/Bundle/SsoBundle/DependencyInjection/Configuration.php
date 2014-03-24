<?php

/*
 * This file is part of the falgun phantom bundle.
 *
 * (c) Threedots.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Threedots\Bundle\SsoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


/**
 * Class Configuration
 * @package Threedots\Bundle\SsoBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{


    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('threedots_sso');

        $rootNode
            ->children()
                ->arrayNode('brokers')
                    ->children()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
