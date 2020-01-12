<?php

namespace LoxBerryPlugin\Core\Frontend\Routing;

use LoxBerryPlugin\Core\Exception\RouteNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;

/**
 * Class PageRouter.
 */
class PageRouter implements PageRouterInterface
{
    const ROUTING_CONFIGURATION = __DIR__.'/../../../../config/routes.yaml';

    /** @var ControllerExecutor */
    private $controllerExecutor;

    /** @var Environment */
    private $twig;

    /**
     * PageRouter constructor.
     *
     * @param ControllerExecutor $controllerExecutor
     * @param Environment        $twig
     */
    public function __construct(ControllerExecutor $controllerExecutor, Environment $twig)
    {
        $this->routes = Yaml::parseFile(self::ROUTING_CONFIGURATION);
        $this->controllerExecutor = $controllerExecutor;
        $this->twig = $twig;
    }

    /**
     * @param string $route
     * @param bool   $isPublic
     *
     * @return Response
     */
    public function process(string $route, bool $isPublic = false): Response
    {
        try {
            $pageConfiguration = $this->getMatchedRoute($route, $isPublic);
            $response = $this->controllerExecutor->getResponse(
                $pageConfiguration->getControllerClassName(),
                $pageConfiguration->getAction()
            );
            $response->prepare(Request::createFromGlobals());
        } catch (RouteNotFoundException $exception) {
            $response = new Response($this->twig->render('error/routeNotFound.html.twig', [
                'exception' => $exception,
            ]), Response::HTTP_NOT_FOUND);
        }

        return $response->send();
    }

    /**
     * @param string $route
     * @param bool   $isPublic
     *
     * @return PageRouteConfiguration
     */
    private function getMatchedRoute(string $route, bool $isPublic): PageRouteConfiguration
    {
        $routes = $this->routes[!$isPublic ? 'admin' : 'public'] ?? [];
        $request = Request::createFromGlobals();

        foreach ($routes as $configuredRoute) {
            $allowedMethods = explode(',', $configuredRoute['method'] ?? Request::METHOD_GET);
            $requestMethod = strtolower($request->getMethod());

            if (
                trim($configuredRoute['route'], '/') === trim($route, '/') &&
                in_array($requestMethod, array_map('trim', array_map('strtolower', $allowedMethods)))
            ) {
                $configuration = new PageRouteConfiguration();
                $configuration->setControllerClassName($configuredRoute['controller']);
                $configuration->setMethod($request->getMethod());
                $configuration->setAction($configuredRoute['action']);
                $configuration->setRoute($configuredRoute['route']);

                return $configuration;
            }
        }

        throw new RouteNotFoundException('No route configuration matches this request.');
    }
}
