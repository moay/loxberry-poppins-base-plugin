<?php

namespace LoxBerryPlugin\Core\Frontend\Twig\Globals;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class LoxBerryTemplating.
 */
class LoxBerryTemplating extends AbstractExtension
{
    public function getFunctions()
    {
        return array(
            new TwigFunction('loxBerryHead',
                [$this, 'printHead'],
                ['is_safe' => 'html']
            ),
        );
    }


    public function printHead()
    {
        return '<h1>Testhead</h1>';
    }
}
