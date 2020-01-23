<?php

namespace LoxBerryPoppinsPlugin\Controller;

use LoxBerryPoppins\Frontend\AbstractController;
use LoxBerryPoppins\Storage\SettingsStorage;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DemoController.
 */
class DemoController extends AbstractController
{
    /** @var SettingsStorage */
    private $settings;

    public function __construct(SettingsStorage $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return Response
     */
    public function demoPage()
    {
        if ($this->getRequest()->request->has('newFieldValue')) {
            $this->settings->set('fieldValue', $this->getRequest()->request->get('newFieldValue'));
        }

        return $this->render('pages/home.html.twig', ['settings' => $this->settings]);
    }
}
