<?php

use LoxBerryPlugin\Core\Frontend\Routing\PageRouter;
use LoxBerryPlugin\Core\PluginKernel;

require_once 'REPLACELBPDATADIR/vendor/autoload.php';

$kernel = new PluginKernel();

$pageRouter = $kernel->getContainer()->get(PageRouter::class);
$pageRouter->process($_GET['route'] ?? '/', true);
