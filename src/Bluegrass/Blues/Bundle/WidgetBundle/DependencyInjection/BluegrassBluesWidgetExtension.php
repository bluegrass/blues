<?php

namespace Bluegrass\Blues\Bundle\WidgetBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BluegrassBluesWidgetExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
    
    public function prepend(ContainerBuilder $container)
    {
        /*
         * Dado que Blues depende de Assetic, se hace un prepend a la configuración
         * de assetic de los paquetes de assets que utiliza blues.
         */
        $config = array(
            'assets' => array(
                'bluegrassblueswidgetbundle_javascripts' => array(
                    'inputs' => array(
                        '@BluegrassBluesWidgetBundle/Resources/public/js/Kendo/Menu/initialize.js',
                        '@BluegrassBluesWidgetBundle/Resources/public/js/Kendo/FilterableMenu/initialize.js',
                        '@BluegrassBluesWidgetBundle/Resources/public/js/Kendo/Grid/initialize.js',
                        '@BluegrassBluesWidgetBundle/Resources/public/js/Kendo/AjaxGrid/initialize.js',
                        '@BluegrassBluesWidgetBundle/Resources/public/js/HTML/FilterableMenu/initialize.js',
                        )
                    )                
                )
            );
        
        foreach ($container->getExtensions() as $name => $extension) {
            switch ($name) {
                case 'assetic':
                    $container->prependExtensionConfig($name, $config);
                    break;
            }
        }                
        
    }           
}
