<?php

namespace LoxBerryPlugin\CronJobs;

use LoxBerryPlugin\Core\Cron\AbstractCronJob;
use LoxBerryPlugin\Core\Cron\CronJobRunner;

/**
 * Class DummyRebootCronJob.
 */
class DummyRebootCronJob extends AbstractCronJob
{
    public function getInterval()
    {
        return CronJobRunner::INTERVAL_REBOOT;
    }

    public function execute()
    {
        $this->getLogger()->info('Reboot Cronjob executed');
    }
}
