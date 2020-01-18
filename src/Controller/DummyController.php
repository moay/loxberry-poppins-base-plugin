<?php

namespace LoxBerryPlugin\Controller;

use LoxBerryPlugin\Core\Frontend\AbstractController;
use LoxBerryPlugin\Core\Storage\SettingsStorage;

/**
 * Class DummyController.
 */
class DummyController extends AbstractController
{
    /** @var SettingsStorage */
    private $settings;

    public function __construct(SettingsStorage $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function testPage()
    {
        if ($this->getRequest()->request->has('newFieldValue')) {
            $this->settings->set('test', $this->getRequest()->request->get('newFieldValue'));
        }

        return $this->render('admin/test.html.twig', [
            'fieldValue' => $this->settings->get('test'),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logsPage()
    {
        return $this->render('admin/loglist.html.twig');
    }
}
