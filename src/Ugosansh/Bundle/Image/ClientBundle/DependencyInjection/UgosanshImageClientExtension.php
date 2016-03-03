<?php

namespace Ugosansh\Bundle\Image\ClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class UgosanshImageClientExtension extends Extension
{
    /**
     * @var string
     */
    const CLIENT_API_SERVICE_NAME = 'ugosansh_image_client.client_api';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);
        $loader        = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');

        if (array_key_exists('entity_class', $config)) {
            $container->setParameter('ugosansh_image_client.entity.class', $config['entity_class']);
        }

        if (array_key_exists('default_image', $config)) {
            $container->setParameter('ugosansh_image_client.image_default', $config['default_image']);
        }

        $container->setAlias(self::CLIENT_API_SERVICE_NAME, $config['client']);
    }

}
