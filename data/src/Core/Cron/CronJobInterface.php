<?php

namespace LoxBerryPlugin\Core\Cron;

interface CronJobInterface
{
    public function getInterval(): int;

    public function execute();
}
