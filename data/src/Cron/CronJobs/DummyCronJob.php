<?php

namespace LoxBerryPlugin\Cron\CronJobs;

use LoxBerry\Logging\Logger;
use LoxBerryPlugin\Cron\CronJobInterface;
use LoxBerryPlugin\Cron\CronJobRunner;
use LoxBerryPlugin\Cron\CronLoggerFactory;

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
