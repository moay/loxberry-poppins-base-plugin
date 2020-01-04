<?php

namespace LoxBerryPlugin\Cron;

use LoxBerry\Logging\Logger;

/**
 * Class CronJobRunner.
 */
class CronJobRunner
{
    const INTERVAL_EVERY_MINUTE = 1;
    const INTERVAL_EVERY_TWO_MINUTES = 2;
    const INTERVAL_EVERY_THREE_MINUTES = 3;
    const INTERVAL_EVERY_FIVE_MINUTES = 5;
    const INTERVAL_EVERY_TEN_MINUTES = 10;
    const INTERVAL_EVERY_TWENTY_MINUTES = 20;
    const INTERVAL_EVERY_HALF_HOUR = 30;
    const INTERVAL_EVERY_HOUR = 60;

    const KNOWN_INTERVALS = [
        self::INTERVAL_EVERY_MINUTE,
        self::INTERVAL_EVERY_TWO_MINUTES,
        self::INTERVAL_EVERY_THREE_MINUTES,
        self::INTERVAL_EVERY_FIVE_MINUTES,
        self::INTERVAL_EVERY_TEN_MINUTES,
        self::INTERVAL_EVERY_TWENTY_MINUTES,
        self::INTERVAL_EVERY_HALF_HOUR,
        self::INTERVAL_EVERY_HOUR,
    ];

    /** @var CronJobInterface[] */
    private $cronJobs = [];

    /** @var Logger */
    private $logger;

    /**
     * CronJobRunner constructor.
     *
     * @param iterable   $cronJobs
     * @param Logger $cronLogger
     */
    public function __construct(iterable $cronJobs, $cronLogger)
    {
        foreach ($cronJobs as $cronJob) {
            if (!$cronJob instanceof CronJobInterface) {
                throw new \InvalidArgumentException('Inject cron jobs only');
            }
            $this->cronJobs[] = $cronJob;
        }
        $this->logger = $cronLogger;
    }

    public function executeCronJobs()
    {
        foreach ($this->cronJobs as $cronJob) {
            if (!in_array($cronJob->getInterval(), self::KNOWN_INTERVALS)) {
                throw new \RuntimeException('Unknown CronJob interval');
            }
            if (0 === round(time() / 60) % $cronJob->getInterval()) {
                $this->logger->log('Executing CronJob '.get_class($cronJob));
                $cronJob->execute();
                $this->logger->log('Finished execution of CronJob '.get_class($cronJob));
            }
        }
    }
}
