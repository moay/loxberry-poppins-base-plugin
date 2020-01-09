<?php

namespace LoxBerryPlugin\Core;

use LoxBerry\ConfigurationParser\ConfigurationParser;
use LoxBerry\Logging\Logger;
use LoxBerry\System\LowLevelExecutor;
use LoxBerry\System\PathProvider;
use LoxBerry\System\Plugin\PluginDatabase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class PluginKernel.
 */
class PluginKernel
{
    const CONFIG_DIRECTORY = __DIR__.'/../../config';
    const DEFAULT_PLUGIN_CONFIGURATION = 'pluginConfiguration.php';
    const ORIGINAL_PLUGIN_CONFIGURATION = __DIR__ . '/../../config/plugin.cfg';
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
        $this->setupErrorHandler();
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

    private function setupErrorHandler()
    {
        $pluginDataBase = new PluginDatabase(new PathProvider(new LowLevelExecutor()));
        if (file_exists(self::ORIGINAL_PLUGIN_CONFIGURATION)) {
            $configuration = new ConfigurationParser(self::ORIGINAL_PLUGIN_CONFIGURATION);
            $pluginName = $configuration->get('PLUGIN', 'NAME');
            $logLevel = $pluginDataBase->getPluginInformation($pluginName)->getLogLevel();
        }
        if (isset($logLevel) && Logger::LOGLEVEL_DEBUG === $logLevel) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }
    }
}
