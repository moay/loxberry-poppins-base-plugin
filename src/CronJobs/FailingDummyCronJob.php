<?php

namespace LoxBerryPoppinsPlugin\CronJobs;

use LoxBerryPoppins\Cron\AbstractCronJob;
use LoxBerryPoppins\Cron\CronJobRunner;

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
