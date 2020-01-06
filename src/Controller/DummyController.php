<?php

namespace LoxBerryPlugin\Controller;

use LoxBerryPlugin\Core\Frontend\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DummyController.
 */
class DummyController extends AbstractController
{
    public function testPage()
    {
        return new Response('Test');
    }
}
