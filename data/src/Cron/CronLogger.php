<?php

namespace LoxBerryPlugin\Cron;

use LoxBerry\Logging\LoggerFactory;
use LoxBerry\System\FileNames;
use LoxBerry\System\PathProvider;
use LoxBerry\System\Paths;

/**
 * Class CronLogger.
 */
class CronLogger
{
    const LOG_NAME = 'Cron';

    /** @var LoggerFactory */
    private $loggerFactory;

    /** @var string */
    private $packageName;

    /** @var PathProvider */
    private $pathProvider;

    /**
     * CronLogger constructor.
     * @param LoggerFactory $loggerFactory
     * @param PathProvider $pathProvider
     * @param $packageName
     */
    public function __construct(
        LoggerFactory $loggerFactory,
        PathProvider $pathProvider,
        $packageName
    ) {
        $this->loggerFactory = $loggerFactory;
        $this->packageName = $packageName;
        $this->pathProvider = $pathProvider;
    }

    /**
     * @return \LoxBerry\Logging\Logger
     */
    public function __invoke()
    {
        return $this->loggerFactory->__invoke(
            self::LOG_NAME,
            $this->packageName,
            $this->pathProvider->getPath(Paths::PATH_PLUGIN_LOG).'/cron.log'
            );
    }
}
