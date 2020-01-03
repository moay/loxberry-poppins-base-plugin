<?php

namespace LoxBerryPlugin\Cron;

use LoxBerry\Logging\Logger;
use LoxBerry\Logging\Logger\AttributeLogger;
use LoxBerry\Logging\Logger\EventLogger;

/**
 * Class CronLogger.
 */
class CronLogger extends Logger
{
    const LOG_NAME = 'Cron';

    /**
     * CronLogger constructor.
     *
     * @param string          $packageName
     * @param EventLogger     $eventLogger
     * @param AttributeLogger $attributeLogger
     */
    public function __construct(
        string $packageName,
        EventLogger $eventLogger,
        AttributeLogger $attributeLogger
    ) {
        parent::__construct(
            self::LOG_NAME,
            $packageName,
            $eventLogger,
            $attributeLogger
        );
    }
}
