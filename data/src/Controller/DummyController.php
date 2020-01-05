<?php

namespace LoxBerryPlugin\Controller;

use LoxBerryPlugin\Core\Frontend\AbstractController;

/**
 * Class DummyController.
 */
class DummyController extends AbstractController
{
    public function testPage()
    {
        die('test');
    }
}
