<?php

namespace LoxBerryPlugin\Core\Frontend\Routing;

use Symfony\Component\Yaml\Yaml;

/**
 * Class RoutingConfigurationParser.
 */
class RoutingConfigurationParser
{
    /** @var array */
    private $routingConfiguration;

    /**
     * RoutingConfigurationParser constructor.
     *
     * @param string $rootPath
     */
    public function __construct($rootPath)
    {
        $this->routingConfiguration = Yaml::parseFile(rtrim($rootPath, '/').'/config/routes.yaml');
    }

    /**
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->routingConfiguration;
    }
}
