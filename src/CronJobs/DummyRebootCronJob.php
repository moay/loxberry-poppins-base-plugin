<?php

namespace LoxBerryPoppinsPlugin\CronJobs;

use LoxBerryPoppins\Cron\AbstractCronJob;
use LoxBerryPoppins\Cron\CronJobRunner;

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
