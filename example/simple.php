<?php

require_once "vendor/autoload.php";

use Diversen\ParallelProcess;

$parallel = new ParallelProcess();
$parallel->addProcess(function () {
    // posix_getpid(); // get the process id of the current process
    echo "Begin sleep 1\n";
    sleep(1);
    echo "End sleep 1\n";
    return 1;
});

$parallel->addProcess(function(){
    echo "Begin sleep 2\n";
    sleep(2);
    echo "End sleep 2\n";
    return 2;
    
});

$parallel->addProcess(function(){
    echo "Begin sleep 3\n";
    sleep(3);
    echo "End sleep 3\n";
    return 3;
});

$results = $parallel->run();
var_dump($results);

// Array with keys of the pids and values of the exit codes
// array(3) {
//     [13380]=>
//     int(1)
//     [13381]=>
//     int(255)
//     [13382]=>
//     int(3)
//   }

// Note: Uncaught exception will give status code 255