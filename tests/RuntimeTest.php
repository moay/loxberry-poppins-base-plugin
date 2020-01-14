<?php

namespace Tests;

use LoxBerryPlugin\Core\Frontend\Twig\Extensions\LoxBerryTemplating;
use PHPUnit\Framework\TestCase;

/**
 * Class RuntimeTest.
 */
class RuntimeTest extends TestCase
{
    public function testLoxBerryTemplatingLoads()
    {
        $kernel = new TestPluginKernel();
        $templating = $kernel->getContainer()->get(LoxBerryTemplating::class);
    }
}
