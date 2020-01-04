<?php

namespace LoxBerryPlugin;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class PluginKernel.
 */
class PluginKernel
{
    const CONFIG_DIRECTORY = __DIR__.'/../config';
    const DEFAULT_PLUGIN_CONFIGURATION = 'pluginConfiguration.php';
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

        $yamlLoader = new YamlFileLoader($containerBuilder, new FileLocator(self::CONFIG_DIRECTORY));
        $yamlLoader->load(self::DEFAULT_SERVICES_CONFIGURATION);

        $phpLoader = new PhpFileLoader($containerBuilder, new FileLocator(self::CONFIG_DIRECTORY));
        $phpLoader->load(self::DEFAULT_PLUGIN_CONFIGURATION);

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
