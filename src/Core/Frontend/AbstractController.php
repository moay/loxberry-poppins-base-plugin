<?php

namespace LoxBerryPlugin\Core\Frontend;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class AbstractController.
 */
abstract class AbstractController
{
    /** @var Request */
    private $request;

    /** @var Environment */
    private $twig;

    /**
     * AbstractController constructor.
     *
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param string $view
     * @param array|null $parameters
     *
     * @return Response
     */
    protected function render(string $view, ?array $parameters = []): Response
    {
        $content = $this->twig->render($view, $parameters);

        return new Response($content);
    }

    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    protected function json(array $data): JsonResponse
    {
        return new JsonResponse($data);
    }
}
