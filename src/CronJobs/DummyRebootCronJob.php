<?php

namespace LoxBerryPlugin\CronJobs;

use LoxBerry\Logging\Logger;
use LoxBerryPlugin\Core\Cron\CronJobInterface;
use LoxBerryPlugin\Core\Cron\CronJobRunner;
use LoxBerryPlugin\Core\Cron\CronLoggerFactory;

/**
 * Class DummyRebootCronJob.
 */
class DummyRebootCronJob implements CronJobInterface
{
    /** @var Logger */
    private $cronLogger;

    /**
     * DummyRebootCronJob constructor.
     *
     * @param CronLoggerFactory $cronLogger
     */
    public function __construct($cronLogger)
    {
        $this->cronLogger = $cronLogger;
    }

    public function getInterval()
    {
        return CronJobRunner::INTERVAL_REBOOT;
    }

    public function execute()
    {
        $this->cronLogger->log('Reboot Cronjob executed', Logger::LOGLEVEL_INFO);
    }
}
