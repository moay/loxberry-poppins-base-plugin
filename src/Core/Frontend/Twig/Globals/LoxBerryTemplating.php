<?php

namespace LoxBerryPlugin\Core\Frontend\Twig\Globals;

use Alar\Template\Template;
use LoxBerry\System\PathProvider;
use LoxBerry\System\Paths;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class LoxBerryTemplating.
 */
class LoxBerryTemplating extends AbstractExtension
{
    /** @var PathProvider */
    private $pathProvider;

    /**
     * LoxBerryTemplating constructor.
     * @param PathProvider $pathProvider
     */
    public function __construct(PathProvider $pathProvider)
    {
        $this->pathProvider = $pathProvider;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('loxBerryHead',
                [$this, 'printHead'],
                ['is_safe' => ['html']]
            ),
        );
    }

    public function printHead(): string
    {
        $template = new Template([
            'paths' => [$this->pathProvider->getPath(Paths::PATH_SYSTEM_TEMPLATE)],
            'filename' => 'head.html'
        ]);

        $template->param('TEMPLATETITLE', 'Test');
        $template->param('LANG', 'de');
        $template->param('HTMLHEAD', '');

        return $template->output();
    }
}
