<?php

namespace LoxBerryPlugin\CronJobs;

use LoxBerryPlugin\Core\Cron\AbstractCronJob;
use LoxBerryPlugin\Core\Cron\CronJobRunner;

/**
 * Class DummyCronJob.
 */
class DummyCronJob extends AbstractCronJob
{
    public function getInterval()
    {
        return CronJobRunner::INTERVAL_EVERY_TEN_MINUTES;
    }

    public function execute()
    {
        $this->getLogger()->info('Cronjob executed');
    }
}
