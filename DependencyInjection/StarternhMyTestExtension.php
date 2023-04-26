<?php

namespace Starternh\MyTestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class StarternhMyTestExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        // $loader->load('services.yaml');
        //
        // $processor = new Processor();
        // $configuration = $this->getConfiguration($configs, $container);
        // $config = $processor->processConfiguration($configuration, $configs);
        //
        // $container->setParameter('starternh_my_test.config', $config);

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $defaults = array_merge(
            [
                'allow_origin' => [],
                'allow_credentials' => false,
                'allow_headers' => [],
                'expose_headers' => [],
                'allow_methods' => [],
                'max_age' => 0,
                'hosts' => [],
                'origin_regex' => false,
            ],
            $config['defaults']
        );

        // normalize array('*') to true
        if (in_array('*', $defaults['allow_origin'])) {
            $defaults['allow_origin'] = true;
        }
        if (in_array('*', $defaults['allow_headers'])) {
            $defaults['allow_headers'] = true;
        } else {
            $defaults['allow_headers'] = array_map('strtolower', $defaults['allow_headers']);
        }
        $defaults['allow_methods'] = array_map('strtoupper', $defaults['allow_methods']);

        if ($config['paths']) {
            foreach ($config['paths'] as $path => $opts) {
                $opts = array_filter($opts);
                if (isset($opts['allow_origin']) && in_array('*', $opts['allow_origin'])) {
                    $opts['allow_origin'] = true;
                }
                if (isset($opts['allow_headers']) && in_array('*', $opts['allow_headers'])) {
                    $opts['allow_headers'] = true;
                } elseif (isset($opts['allow_headers'])) {
                    $opts['allow_headers'] = array_map('strtolower', $opts['allow_headers']);
                }
                if (isset($opts['allow_methods'])) {
                    $opts['allow_methods'] = array_map('strtoupper', $opts['allow_methods']);
                }

                $config['paths'][$path] = $opts;
            }
        }

        $container->setParameter('my_test.map', $config['paths']);
        $container->setParameter('my_test.defaults', $defaults);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration();
    }
}
