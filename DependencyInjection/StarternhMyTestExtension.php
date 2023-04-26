<?php

namespace Starternh\MyTestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class StarternhMyTestExtension extends Extension
{
    // /**
    //  * {@inheritdoc}
    //  */
    // public function load(array $configs, ContainerBuilder $container)
    // {
    //     // Has what is in config/packages/owner_test.yaml
    //     // dump($configs);
    //     //
    //     // $configuration = new Configuration();
    //     //
    //     // $config = $this->processConfiguration($configuration, $configs);
    //     // dump($config);
    //
    //     // At this point you would use $config to define your parameters or services
    //
    //     $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    //     $loader->load('services.yaml');
    //
    //     $configuration = new Configuration();
    //     $config = $this->processConfiguration($configuration, $configs);
    //     // $processor = new Processor();
    //     // $configuration = $this->getConfiguration($configs, $container);
    //
    //     foreach ($config as $key => $value) {
    //         $container->setParameter('my_test.' . $key, $value);
    //     }
    //     // $container->setParameter('my_test.config', $config);
    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function getConfiguration(array $config, ContainerBuilder $container)
    // {
    //     return new Configuration();
    // }

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('gregwar_captcha.config', $config);
        $container->setParameter('gregwar_captcha.config.image_folder', $config['image_folder']);
        $container->setParameter('gregwar_captcha.config.web_path', $config['web_path']);
        $container->setParameter('gregwar_captcha.config.gc_freq', $config['gc_freq']);
        $container->setParameter('gregwar_captcha.config.expiration', $config['expiration']);
        $container->setParameter('gregwar_captcha.config.whitelist_key', $config['whitelist_key']);

        $resources = $container->getParameter('twig.form.resources');
        $container->setParameter('twig.form.resources', array_merge(array('@GregwarCaptcha/captcha.html.twig'), $resources));
    }
}
