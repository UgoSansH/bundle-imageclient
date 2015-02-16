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
                ->arrayNode('api')
                    ->children()
                        ->scalarNode('base_url')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->variableNode('config')
                            ->validate()
                                ->ifTrue(function($v){
                                    return !is_array($v);
                                })
                                ->thenInvalid('Invalid value %s for client config, it must be an array.')
                            ->end()
                        ->end()
                        ->arrayNode('cache')
                            ->children()
                                ->scalarNode('ttl')->defaultValue(86400)->end()
                                ->booleanNode('force_request_ttl')->defaultValue(false)->end()
                                ->scalarNode('service')->end()
                                ->scalarNode('adapter')->end()
                                ->scalarNode('storage')->end()
                                ->scalarNode('subscriber')->end()
                                ->arrayNode('can_cache')
                                    ->children()
                                        ->scalarNode('class')->end()
                                        ->scalarNode('method')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('options')
                                    ->children()
                                        ->booleanNode('validate')->end()
                                        ->booleanNode('purge')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('logger')->end()
                ->scalarNode('default_image')->end()
                ->scalarNode('entity_class')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
