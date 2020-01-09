<?php

namespace LoxBerryPlugin\Core\Frontend\Rendering;

/**
 * Class TwigEnvironmentFactory.
 */
class TwigEnvironmentFactory
{
    const TWIG_CACHE_FOLDER = 'cache/views';
    const TWIG_VIEWS_FOLDER = 'views';

    public static function createEnvironment(string $rootPath) {
        foreach (explode('/', trim(self::TWIG_CACHE_FOLDER, '/')) as $subfolder) {
            $folder = ($folder ?? $rootPath) . '/' . $subfolder;
            if (!mkdir($folder) && !is_dir($folder)) {
                throw new \RuntimeException('Cache folder could not be created.');
            }
        }
        $loader = new \Twig\Loader\FilesystemLoader($rootPath.'/'.trim('/', self::TWIG_VIEWS_FOLDER));
        $twig = new \Twig\Environment($loader, [
            'cache' => $rootPath.'/'.trim('/', self::TWIG_CACHE_FOLDER),
        ]);

        return $twig;
    }
}
