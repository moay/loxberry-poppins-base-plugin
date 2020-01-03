<?php

namespace LoxBerryPlugin;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class PluginKernel.
 */
class PluginKernel
{
    const CONFIG_DIRECTORY = __DIR__.'/../config';
    const DEFAULT_PARAMETERS_CONFIGURATION = 'parameters.yaml';
    const DEFAULT_SERVICES_CONFIGURATION = 'services.yaml';

    /** @var ContainerBuilder */
    private $container;

    /**
     * PluginKernel constructor.
     *
     * @param string $pluginConfigurationFile
     */
    public function __construct()
    {
        $this->loadContainer();
    }

    private function loadContainer()
    {
        $containerBuilder = new ContainerBuilder();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator(self::CONFIG_DIRECTORY));
        $loader->load(self::DEFAULT_PARAMETERS_CONFIGURATION);
        $loader->load(self::DEFAULT_SERVICES_CONFIGURATION);
        $containerBuilder->compile();

        $this->container = $containerBuilder;
    }

    /**
     * @return ContainerBuilder
     */
    public function getContainer(): ContainerBuilder
    {
        return $this->container;
    }
}
