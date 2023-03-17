<?php

require_once "vendor/autoload.php";

use Diversen\ParallelProcess;

$parallel = new ParallelProcess();

// Try with 1000 processes
for ($i = 0; $i < 1000; $i++) {
    $parallel->addProcess(function () {
        return 1;
    });
}

$results = $parallel->run();
var_dump($results);
