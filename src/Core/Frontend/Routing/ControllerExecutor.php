<?php

namespace LoxBerryPlugin\Core\Frontend\Routing;

use LoxBerryPlugin\Core\Exception\RouteNotFoundException;
use LoxBerryPlugin\Core\Frontend\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ControllerExecutor.
 */
class ControllerExecutor
{
    /** @var AbstractController[] */
    private $controllers = [];

    /**
     * ControllerExecutor controller.
     *
     * @param iterable $controllers
     */
    public function __construct(iterable $controllers)
    {
        foreach ($controllers as $controller) {
            if (!$controller instanceof AbstractController) {
                throw new \RuntimeException('Misconfigured controller or misusage of ControllerExecutor');
            }
            $this->controllers[] = $controller;
        }
    }

    /**
     * @param string $controllerClassName
     * @param string $actionName
     *
     * @return Response
     */
    public function getResponse(string $controllerClassName, string $actionName): Response
    {
        foreach ($this->controllers as $controller) {
            if (get_class($controller) === $controllerClassName) {
                if (!method_exists($controller, $actionName)) {
                    throw new RouteNotFoundException(sprintf('Method %s does not exist on controller %s', $actionName, $controllerClassName));
                }

                $controller->setRequest(Request::createFromGlobals());
                $response = $controller->{$actionName}();
                if (!$response instanceof Response) {
                    throw new \RuntimeException('Your controller must return an object of type Response.');
                }

                return $response;
            }
        }

        throw new \RuntimeException(sprintf('Controller %s not found', $controllerClassName));
    }
}
