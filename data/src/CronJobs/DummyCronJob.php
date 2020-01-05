<?php

namespace LoxBerryPlugin\Cron\CronJobs;

use LoxBerry\Logging\Logger;
use LoxBerryPlugin\Core\Cron\CronJobInterface;
use LoxBerryPlugin\Core\Cron\CronJobRunner;
use LoxBerryPlugin\Core\Cron\CronLoggerFactory;

/**
 * Class DummyCronJob.
 */
class DummyCronJob implements CronJobInterface
{
    /** @var Logger */
    private $cronLogger;

    /**
     * DummyCronJob constructor.
     *
     * @param CronLoggerFactory $cronLogger
     */
    public function __construct($cronLogger)
    {
        $this->cronLogger = $cronLogger;
    }

    public function getInterval(): int
    {
        return CronJobRunner::INTERVAL_EVERY_MINUTE;
    }

    public function execute()
    {
        $this->cronLogger->log('Cronjob executed', Logger::LOGLEVEL_INFO);
    }
}
