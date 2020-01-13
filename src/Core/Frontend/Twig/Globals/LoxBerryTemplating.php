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

    /** @var string */
    private $templateDirectory;

    /**
     * LoxBerryTemplating constructor.
     * @param PathProvider $pathProvider
     */
    public function __construct(PathProvider $pathProvider)
    {
        $this->pathProvider = $pathProvider;
        $this->templateDirectory = rtrim($this->pathProvider->getPath(Paths::PATH_SYSTEM_TEMPLATE), '/');
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions(): array
    {
        return array(
            new TwigFunction('loxBerryHtmlHead',
                [$this, 'htmlHead'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction('loxBerryHtmlFoot',
                [$this, 'htmlFoot'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction('loxBerryPageStart',
                [$this, 'pageStart'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction('loxBerryPageEnd',
                [$this, 'pageEnd'],
                ['is_safe' => ['html']]
            ),
        );
    }

    /**
     * @return string
     */
    public function htmlHead(): string
    {
        $templateFile = $this->templateDirectory.'/head.html';

        return $this->readTemplate($templateFile, [
            'TEMPLATETITLE' => 'Test',
            'LANG' => 'de',
            'HTMLHEAD' => '',
        ]);
    }

    /**
     * @return string
     */
    public function htmlFoot(): string
    {
        $templateFile = $this->templateDirectory.'/foot.html';

        return $this->readTemplate($templateFile, [
            'LANG' => 'de',
        ]);
    }

    public function pageStart(bool $hidePanels = true): string
    {
        $templateFile = $this->templateDirectory.($hidePanels ? '/pagestart_nopanels.html' : '/pagestart.html');

        return $this->readTemplate($templateFile, [
            'TEMPLATETITLE' => 'Test',
            'HELPLINK' => 'https://google.com',
            'PAGE' => 'test',
            'LANG' => 'de',
        ]);
    }

    public function pageEnd(): string
    {
        $templateFile = $this->templateDirectory.'/pageend.html';

        return $this->readTemplate($templateFile, [
            'LANG' => 'de',
        ]);
    }

    /**
     * @param string $fileName
     * @param array $variables
     *
     * @return string
     */
    private function readTemplate(string $fileName, array $variables = []): string
    {
        if (!file_exists($fileName)) {
            throw new \RuntimeException('Template file does not exist');
        }

        $content = file_get_contents($fileName);
        foreach ($variables as $key => $value) {
            $content = str_replace('<TMPL_VAR '.$key.'>', $value, $content);
        }

        return $content;
    }
}
