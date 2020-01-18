<?php

use LoxBerryPlugin\Core\Frontend\Routing\PageRouterInterface;
use LoxBerryPlugin\Core\PluginKernel;

require_once 'REPLACELBPDATADIR/vendor/autoload.php';

$kernel = new PluginKernel('REPLACELBPDATADIR');

$pageRouter = $kernel->getContainer()->get(PageRouterInterface::class);
$pageRouter->process(true);
