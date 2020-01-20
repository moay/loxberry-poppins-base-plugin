<?php

namespace LoxBerryPlugin\CronJobs;

use LoxBerryPlugin\Core\Cron\AbstractCronJob;
use LoxBerryPlugin\Core\Cron\CronJobRunner;

/**
 * Class FailingDummyCronJob.
 */
class FailingDummyCronJob extends AbstractCronJob
{
    public function getInterval()
    {
        return CronJobRunner::INTERVAL_EVERY_TWENTY_MINUTES;
    }

    public function execute()
    {
        $this->getLogger()->info('Going to throw an error');
        throw new \RuntimeException('Something went wrong');
    }
}
