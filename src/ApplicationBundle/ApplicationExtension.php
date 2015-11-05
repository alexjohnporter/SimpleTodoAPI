<?php

namespace ApplicationBundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ApplicationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/Configuration'));
        $loader->load('services.xml');
    }

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return null;
    }
}
