<?php

namespace LoxBerryPlugin\Tests;

use LoxBerryPlugin\LoxBerryPlugin;
use PHPUnit\Framework\TestCase;

/**
 * Class LoxBerryPluginTest.
 */
class LoxBerryPluginTest extends TestCase
{
    public function testSetupWorks()
    {
        $loxBerry = new LoxBerryPlugin();
        $this->assertTrue($loxBerry->testSetup());
    }
}
