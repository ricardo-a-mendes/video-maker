<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands
$application->add(new \VMaker\Command\CreateVideoCommand());

$application->run();
//return $application;
