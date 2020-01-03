<?php

namespace LoxBerryPlugin\Cron;

interface CronJobInterface
{
    public function getInterval(): int;

    public function execute();
}
