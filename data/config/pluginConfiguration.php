<?php

use LoxBerry\ConfigurationParser\ConfigurationParser;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function(ContainerConfigurator $configurator) {
    if (file_exists(__DIR__.'/plugin.cfg')) {
        $configuration = new ConfigurationParser(__DIR__.'/plugin.cfg');

        $configurator->parameters()
            ->set('plugin.name', $configuration->get('PLUGIN', 'NAME'))
            ->set('plugin.version', $configuration->get('PLUGIN', 'VERSION'))
            ->set('plugin.directory', $configuration->get('PLUGIN', 'FOLDER'))
            ->set('plugin.title', $configuration->get('PLUGIN', 'TITLE'))
        ;
    } else {
        throw new \RuntimeException('Cannot load plugin configuration. Configuration file missing.');
    }
};
