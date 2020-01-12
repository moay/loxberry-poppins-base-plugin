<?php

namespace LoxBerryPlugin\Core\Frontend\Twig;

use LoxBerry\ConfigurationParser\MiniserverInformation;
use LoxBerry\Logging\Logger;
use LoxBerry\System\Plugin\PluginDatabase;
use LoxBerry\System\Plugin\PluginInformation;
use LoxBerryPlugin\Core\Frontend\Twig\Globals\LoxBerryTemplating;
use Twig\Environment;

/**
 * Class TwigEnvironmentFactory.
 */
class TwigEnvironmentFactory
{
    const TWIG_CACHE_FOLDER = 'cache/views';
    const TWIG_VIEWS_FOLDER = 'views';

    /** @var string */
    private $rootPath;

    /** @var PluginInformation */
    private $pluginInformation;

    /** @var MiniserverInformation */
    private $miniserverInformation;

    /** @var LoxBerryTemplating */
    private $loxBerryTemplating;

    /**
     * TwigEnvironmentFactory constructor.
     *
     * @param string $rootPath
     * @param $packageName
     * @param PluginDatabase        $pluginDatabase
     * @param MiniserverInformation $miniserverInformation
     * @param LoxBerryTemplating    $loxBerryTemplating
     */
    public function __construct(
        string $rootPath,
        $packageName,
        PluginDatabase $pluginDatabase,
        MiniserverInformation $miniserverInformation,
        LoxBerryTemplating $loxBerryTemplating
    ) {
        $this->rootPath = $rootPath;
        $this->pluginInformation = $pluginDatabase->getPluginInformation($packageName);
        $this->miniserverInformation = $miniserverInformation;
        $this->loxBerryTemplating = $loxBerryTemplating;
    }

    /**
     * @return \Twig\Environment
     */
    public function __invoke(): Environment
    {
        foreach (explode('/', trim(self::TWIG_CACHE_FOLDER, '/')) as $subfolder) {
            $folder = ($folder ?? $this->rootPath).'/'.$subfolder;
            if (!mkdir($folder) && !is_dir($folder)) {
                throw new \RuntimeException('Cache folder could not be created.');
            }
        }

        $logLevel = $this->pluginInformation->getLogLevel();

        $loader = new \Twig\Loader\FilesystemLoader($this->rootPath.'/'.trim(self::TWIG_VIEWS_FOLDER, '/'));
        $twig = new \Twig\Environment($loader, [
            'cache' => $this->rootPath.'/'.trim(self::TWIG_CACHE_FOLDER, '/'),
            'debug' => Logger::LOGLEVEL_DEBUG === $logLevel,
        ]);

        $this->registerGlobals($twig);

        return $twig;
    }

    /**
     * @param Environment $twig
     */
    private function registerGlobals(Environment $twig)
    {
        $twig->addGlobal('plugin', $this->pluginInformation);
        $twig->addGlobal('miniserver', $this->miniserverInformation);
        $twig->addGlobal('templating', $this->loxBerryTemplating);
    }
}
