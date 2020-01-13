<?php

namespace LoxBerryPlugin\Core\Frontend\Twig\Utility;

use LoxBerry\System\Localization\TranslationProvider;

/**
 * Class TranslatedSystemTemplateLoader.
 */
class TranslatedSystemTemplateLoader
{
    /** @var TranslationProvider */
    private $translationProvider;

    /**
     * TranslatedSystemTemplateLoader constructor.
     *
     * @param TranslationProvider $translationProvider
     */
    public function __construct(TranslationProvider $translationProvider)
    {
        $this->translationProvider = $translationProvider;
    }

    /**
     * @param string $fileName
     * @param array $translatedSections
     *
     * @return string
     */
    public function loadTranslatedFile(string $fileName, array $translatedSections = []): string
    {
        if (!file_exists($fileName)) {
            throw new \RuntimeException(sprintf('Template file %s could not be found', $fileName));
        }

        $templateContent = file_get_contents($fileName);

        foreach ($translatedSections as $section) {
            $translations = $this->translationProvider->getSystemTranslations();
            preg_match_all('/\<TMPL_VAR '.$section.'\.([A-Za-z0-9-_]+)\>/', $templateContent, $matches);
            foreach ($matches as $toReplace) {
                $translated = $translations->get($section, $toReplace);
                $templateContent = str_replace(sprintf('<TMPL_VAR %s.%s>', $section, $toReplace), $translated, $templateContent);
            }
        }

        return $templateContent;
    }
}
