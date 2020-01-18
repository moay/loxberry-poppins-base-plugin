<?php

namespace LoxBerryPlugin\Core\Cron;

interface CronJobInterface
{
    public function getInterval();

    public function execute();
}
