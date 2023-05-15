<?php

declare(strict_types=1);

namespace Dbp\Relay\EducationalcredentialsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('dbp_relay_educationalcredentials');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('issuer')->end()
            ->scalarNode('urlIssuer')->end()
            ->scalarNode('urlVerifier')->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
