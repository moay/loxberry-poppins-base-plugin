<?php

use LoxBerryPlugin\Core\Cron\CronJobRunner;
use LoxBerryPlugin\Core\PluginKernel;

require_once __DIR__.'/../vendor/autoload.php';

$kernel = new PluginKernel();

$cronJobRunner = $kernel->getContainer()->get(CronJobRunner::class);
$cronJobRunner->executeCronJobs();
