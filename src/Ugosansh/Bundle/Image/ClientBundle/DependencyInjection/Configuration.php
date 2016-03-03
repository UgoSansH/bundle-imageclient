<?php

namespace Ugosansh\Bundle\Image\ClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('ugosansh_image_client');

        $rootNode
            ->children()
                ->scalarNode('client')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('logger')->end()
                ->scalarNode('default_image')->end()
                ->scalarNode('entity_class')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
