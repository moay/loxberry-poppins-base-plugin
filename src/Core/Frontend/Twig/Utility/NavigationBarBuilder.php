<?php

namespace LoxBerryPlugin\Core\Frontend\Twig\Utility;

use LoxBerryPlugin\Core\Frontend\Navigation\NavigationConfigurationParser;
use LoxBerryPlugin\Core\Frontend\Navigation\UrlBuilder;
use LoxBerryPlugin\Core\Frontend\Routing\RouteMatcher;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NavigationBarBuilder.
 */
class NavigationBarBuilder
{
    /** @var array */
    private $navigationConfiguration;

    /** @var RouteMatcher */
    private $routeMatcher;

    /** @var UrlBuilder */
    private $urlBuilder;

    /**
     * NavigationBarBuilder constructor.
     *
     * @param NavigationConfigurationParser $navigationConfigurationParser
     * @param RouteMatcher $routeMatcher
     * @param UrlBuilder $urlBuilder
     */
    public function __construct(
        NavigationConfigurationParser $navigationConfigurationParser,
        RouteMatcher $routeMatcher,
        UrlBuilder $urlBuilder
    ) {
        $this->navigationConfiguration = $navigationConfigurationParser->getConfiguration();
        $this->request = Request::createFromGlobals();
        $this->routeMatcher = $routeMatcher;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @return string
     */
    public function getNavigationBarHtml(): string
    {
        if (count($this->navigationConfiguration) === 0) {
            return '';
        }

        $navigationBar = '<div data-role="navbar"><ul>';
        foreach ($this->navigationConfiguration as $index => $navigationItem) {
            $navigationBar .= sprintf(
                '<li><div style="position:relative"><a href="%s" %s %s>%s</a></div></li>',
                $this->urlBuilder->getAdminUrl($navigationItem['route']),
                array_key_exists('target', $navigationItem) ? 'target="' . $navigationItem['target'] . '"' : '',
                array_key_exists('route', $navigationItem) ?
                    $this->routeMatcher->isCurrentMatchedRoute($navigationItem['route'], false) : '',
                $navigationItem['title'] ?? $index
            );
        }
        $navigationBar .= '</ul></div>';

        return $navigationBar;
    }
}
