<?php

namespace LoxBerryPlugin\Core\Frontend\Routing;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

/**
 * Class PageRouter.
 */
class PageRouter implements PageRouterInterface
{
    const ROUTING_CONFIGURATION = __DIR__.'/../../../../config/routes.yaml';

    /** @var ControllerExecutor */
    private $controllerExecutor;

    /**
     * PageRouter constructor.
     *
     * @param ControllerExecutor $controllerExecutor
     */
    public function __construct(ControllerExecutor $controllerExecutor)
    {
        $this->routes = Yaml::parseFile(self::ROUTING_CONFIGURATION);
        $this->controllerExecutor = $controllerExecutor;
    }

    /**
     * @param string $route
     * @param bool   $isPublic
     *
     * @return Response
     */
    public function process(string $route, bool $isPublic = false): Response
    {
        $pageConfiguration = $this->getMatchedRoute($route, $isPublic);

        if (null === $pageConfiguration) {
            die('500');
        }

        $response = $this->controllerExecutor->getResponse(
            $pageConfiguration->getControllerClassName(),
            $pageConfiguration->getMethod()
        );
        $response->prepare(Request::createFromGlobals());

        return $response->send();
    }

    /**
     * @param string $route
     * @param bool   $isPublic
     *
     * @return PageRouteConfiguration|null
     */
    private function getMatchedRoute(string $route, bool $isPublic): ?PageRouteConfiguration
    {
        $routes = $this->routes[!$isPublic ? 'admin' : 'public'] ?? [];

        foreach ($routes as $configuredRoute) {
            if (trim($configuredRoute['route'], '/') === trim($route, '/')) {
                $configuration = new PageRouteConfiguration();
                $configuration->setControllerClassName($configuredRoute['controller']);
                $configuration->setMethod($configuredRoute['method']);
                $configuration->setRoute($configuredRoute['route']);

                return $configuration;
            }
        }

        return null;
    }
}
