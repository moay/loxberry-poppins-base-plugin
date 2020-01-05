<?php

namespace LoxBerryPlugin\Core\Frontend;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractController.
 */
abstract class AbstractController
{
    /** @var Request */
    private $request;

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
    public function getRequest(): Request
    {
        return $this->request;
    }
}
