<?php

namespace LoxBerryPlugin\Core\Frontend\Routing;

use Symfony\Component\HttpFoundation\Response;

interface PageRouterInterface
{
    public function process(string $route, bool $isPublic = false): Response;
}
