<?php

use LoxBerry\ConfigurationParser\ConfigurationParser;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function(ContainerConfigurator $configurator) {
    $configurationFile = __DIR__ . '/../../plugin.cfg';

    if (!file_exists($configurationFile)) {
        throw new \RuntimeException('Cannot load plugin configuration. Configuration file missing.');
    }

    $configuration = new ConfigurationParser($configurationFile);

    $configurator->parameters()
        ->set('plugin.name', $configuration->get('PLUGIN', 'NAME'))
        ->set('plugin.version', $configuration->get('PLUGIN', 'VERSION'))
        ->set('plugin.directory', $configuration->get('PLUGIN', 'FOLDER'))
        ->set('plugin.title', $configuration->get('PLUGIN', 'TITLE'))
        ->set('runtime.root_dir', realpath(dirname(__DIR__)))
    ;
};
