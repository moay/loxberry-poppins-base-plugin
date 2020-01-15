<?php

namespace LoxBerryPlugin\Core\Frontend\Twig\Extensions;

use LoxBerry\ConfigurationParser\SystemConfigurationParser;
use LoxBerry\System\Localization\LanguageDeterminator;
use LoxBerry\System\Localization\LanguageFileParser;
use LoxBerry\System\Localization\TranslationProvider;
use LoxBerry\System\PathProvider;
use LoxBerry\System\Paths;
use LoxBerryPlugin\Core\Frontend\Twig\Utility\NavigationBarBuilder;
use LoxBerryPlugin\Core\Frontend\Twig\Utility\TranslatedSystemTemplateLoader;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class LoxBerryTemplateElements.
 */
class LoxBerryTemplateElements extends AbstractExtension
{
    /** @var PathProvider */
    private $pathProvider;

    /** @var string */
    private $templateDirectory;

    /** @var LanguageFileParser */
    private $systemTranslations;

    /** @var LanguageFileParser */
    private $pluginTranslations;
    /** @var string */
    private $packageName;

    /**
     * LoxBerryTemplateElements constructor.
     *
     * @param PathProvider $pathProvider
     * @param TranslationProvider $translationProvider
     * @param string $packageName
     */
    public function __construct(
        PathProvider $pathProvider,
        TranslationProvider $translationProvider,
        $packageName
    ) {
        $this->pathProvider = $pathProvider;
        $this->templateDirectory = rtrim($this->pathProvider->getPath(Paths::PATH_SYSTEM_TEMPLATE), '/');
        $this->systemTranslations = $translationProvider->getSystemTranslations();
        $this->pluginTranslations = $translationProvider->getPluginTranslations($packageName);
        $this->packageName = $packageName;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'logFileButton',
                [$this, 'getLogFileButton'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'logListUrl',
                [$this, 'getLogListUrl'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'logListButton',
                [$this, 'getLogListButton'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'logList',
                [$this, 'getLogList'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'miniserverSelect',
                [$this, 'getMiniserverSelect'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'logLevelSelect',
                [$this, 'getLogLevelSelect'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    public function getLogFileButton(string $logFile, ?string $label = null, bool $mini = true, ?string $icon = 'action'): string
    {
        if ($label === null) {
            $label = $this->systemTranslations->getTranslated('COMMON.BUTTON_LOGFILE');
        } else {
            $label = $this->pluginTranslations->getTranslated($label);
        }

        return sprintf(
            '<a data-role="button" href="/admin/system/tools/logfile.cgi?logfile=%s&package=%s&header=html&format=template" target="_blank" data-inline="true" data-mini="%s" data-icon="%s">%s</a>',
            $logFile,
            $this->packageName,
            $mini ? 'true' : 'false',
            $icon,
            $label
        );
    }

    public function getLogListUrl(): string
    {

    }

    public function getLogListButton(): string
    {

    }

    public function getLogList(): string
    {

    }

    public function getMiniserverSelect(): string
    {

    }

    public function getLogLevelSelect(): string
    {

    }
}
