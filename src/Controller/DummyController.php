<?php

namespace LoxBerryPlugin\Controller;

use LoxBerryPlugin\Core\Frontend\AbstractController;

/**
 * Class DummyController.
 */
class DummyController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function testPage()
    {
        return $this->render('admin/test.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logsPage()
    {
        return $this->render('admin/loglist.html.twig');
    }
}
