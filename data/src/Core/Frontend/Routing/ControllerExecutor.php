<?php

namespace LoxBerryPlugin\Core\Frontend\Routing;

use LoxBerryPlugin\Core\Frontend\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ControllerExecutor.
 */
class ControllerExecutor
{
    /** @var AbstractController[] */
    private $controllers = [];

    /** @var RequestStack */
    private $requestStack;

    /**
     * ControllerExecutor controller.
     *
     * @param iterable $controllers
     */
    public function __construct(iterable $controllers, RequestStack $requestStack)
    {
        foreach ($controllers as $controller) {
            if (!$controller instanceof AbstractController) {
                throw new \RuntimeException('Misconfigured controller or misusage of ControllerExecutor');
            }
            $this->controllers[] = $controller;
        }
        $this->requestStack = $requestStack;
    }

    /**
     * @param string $controllerClassName
     * @param string $methodName
     *
     * @return Response
     */
    public function getResponse(string $controllerClassName, string $methodName): Response
    {
        foreach ($this->controllers as $controller) {
            if (get_class($controller) === $controllerClassName) {
                if (!method_exists($controller, $methodName)) {
                    throw new \RuntimeException(sprintf('Method %s does not exist on controller %s', $methodName, $controllerClassName));
                }

                $controller->setRequest($this->requestStack->getCurrentRequest());
                $response = $controller->{$methodName}();
                if (!$response instanceof Response) {
                    throw new \RuntimeException('Your controller must return an object of type Response.');
                }

                return $response;
            }
        }

        throw new \RuntimeException(sprintf('Controller %s not found', $controllerClassName));
    }
}
