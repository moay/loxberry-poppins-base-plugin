<?php

namespace LoxBerryPlugin\Core\Frontend\Twig\Utility;

/**
 * Class NavigationBarBuilder.
 */
class NavigationBarBuilder
{
    public function __construct(NavigationConfigurationParser $configurationParser)
    {
    }

    public function getNavigationBarHtml(): string
    {
        return 'test';
    }

    public function getNavigationBarJavaScript(): string
    {
        return 'test';
    }
}
