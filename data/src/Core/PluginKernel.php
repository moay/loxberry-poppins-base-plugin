<?php

namespace LoxBerryPlugin\Core;

use LoxBerry\Logging\Logger;
use LoxBerry\System\LowLevelExecutor;
use LoxBerry\System\PathProvider;
use LoxBerry\System\Plugin\PluginDatabase;
use SlashTrace\EventHandler\DebugHandler;
use SlashTrace\SlashTrace;
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
        $this->setupErrorHandler();
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
        $pluginName = $this->container->getParameter('plugin.name');
        $logLevel = $pluginDataBase->getPluginInformation($pluginName)->getLogLevel();
        if (Logger::LOGLEVEL_DEBUG === $logLevel) {
            error_reporting(E_ALL);
            $slashtrace = new SlashTrace();
            $slashtrace->addHandler(new DebugHandler());
            $slashtrace->register();
        }
    }
}
