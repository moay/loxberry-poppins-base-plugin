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

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions(): array
    {
        return array(
            new TwigFunction('loxBerryHead',
                [$this, 'printHead'],
                ['is_safe' => ['html']]
            ),
        );
    }

    /**
     * @return string
     */
    public function printHead(): string
    {
        $templateDirectory = $this->pathProvider->getPath(Paths::PATH_SYSTEM_TEMPLATE);
        $templateFile = rtrim($templateDirectory, '/').'/head.html';

        return $this->readTemplate($templateFile, [
            'TEMPLATETITLE' => 'Test',
            'LANG' => 'de',
            'HTMLHEAD' => '',
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
