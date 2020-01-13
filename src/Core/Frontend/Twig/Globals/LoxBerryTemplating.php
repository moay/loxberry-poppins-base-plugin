<?php

namespace LoxBerryPlugin\Core\Frontend\Twig\Globals;

use Alar\Template\Template;
use LoxBerry\ConfigurationParser\SystemConfigurationParser;
use LoxBerry\System\Localization\LanguageDeterminator;
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

    /** @var SystemConfigurationParser */
    private $systemConfigurationParser;

    /** @var LanguageDeterminator */
    private $languageDeterminator;

    /**
     * LoxBerryTemplating constructor.
     *
     * @param PathProvider $pathProvider
     * @param SystemConfigurationParser $systemConfigurationParser
     * @param LanguageDeterminator $languageDeterminator
     */
    public function __construct(
        PathProvider $pathProvider,
        SystemConfigurationParser $systemConfigurationParser,
        LanguageDeterminator $languageDeterminator
    ) {
        $this->pathProvider = $pathProvider;
        $this->templateDirectory = rtrim($this->pathProvider->getPath(Paths::PATH_SYSTEM_TEMPLATE), '/');
        $this->systemConfigurationParser = $systemConfigurationParser;
        $this->languageDeterminator = $languageDeterminator;
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
    public function htmlHead(?string $pageTitle = null, ?string $htmlHead = ''): string
    {
        $templateFile = $this->templateDirectory . '/head.html';
        $pageTitle = $pageTitle !== null ?
            $pageTitle . ' ' . $this->systemConfigurationParser->getNetworkName() :
            $this->systemConfigurationParser->getNetworkName();


        return $this->readTemplate($templateFile, [
            'TEMPLATETITLE' => $pageTitle,
            'LANG' => $this->languageDeterminator->getLanguage(),
            'HTMLHEAD' => $htmlHead,
        ]);
    }

    /**
     * @return string
     */
    public function htmlFoot(): string
    {
        $templateFile = $this->templateDirectory . '/foot.html';

        return $this->readTemplate($templateFile, [
            'LANG' => 'de',
        ]);
    }

    public function pageStart(bool $hidePanels = true): string
    {
        $templateFile = $this->templateDirectory . ($hidePanels ? '/pagestart_nopanels.html' : '/pagestart.html');

        return $this->readTemplate($templateFile, [
            'TEMPLATETITLE' => 'Test',
            'HELPLINK' => 'https://google.com',
            'PAGE' => 'test',
            'LANG' => 'de',
        ]);
    }

    public function pageEnd(): string
    {
        $templateFile = $this->templateDirectory . '/pageend.html';

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
            $content = str_replace('<TMPL_VAR ' . $key . '>', $value, $content);
        }

        return $content;
    }
}
