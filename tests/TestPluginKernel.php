<?php

namespace Tests;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class TestPluginKernel.
 */
class TestPluginKernel
{
    const TEST_CONFIG_DIRECTORY = __DIR__.'/config';
    const TEST_SERVICES_CONFIGURATION = 'services_test.yaml';
    const TEST_PLUGIN_CONFIGURATION = 'testPluginConfiguration.php';

    /** @var ContainerBuilder */
    private $container;

    public function __construct()
    {
        $this->loadContainer();
    }

    private function loadContainer()
    {
        $containerBuilder = new ContainerBuilder();

        $testYamlLoader = new YamlFileLoader($containerBuilder, new FileLocator(self::TEST_CONFIG_DIRECTORY));
        $testYamlLoader->load(self::TEST_SERVICES_CONFIGURATION);

        $phpLoader = new PhpFileLoader($containerBuilder, new FileLocator(self::TEST_CONFIG_DIRECTORY));
        $phpLoader->load(self::TEST_PLUGIN_CONFIGURATION);

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
