<?php

namespace LoxBerryPlugin\Core\Frontend\Routing;

use Symfony\Component\HttpFoundation\Response;

interface PageRouterInterface
{
    public function process(bool $isPublic = false): Response;
}
