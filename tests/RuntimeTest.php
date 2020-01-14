<?php

namespace Tests;

use LoxBerryPlugin\Core\Frontend\Twig\Extensions\LoxBerryTemplating;
use LoxBerryPlugin\Core\PluginKernel;
use PHPUnit\Framework\TestCase;

/**
 * Class RuntimeTest.
 */
class RuntimeTest extends TestCase
{
    public function testLoxBerryTemplatingLoads()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');

        $kernel = new TestPluginKernel();
        $templating = $kernel->getContainer()->get(LoxBerryTemplating::class);
    }
}
