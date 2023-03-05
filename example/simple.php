<?php

require_once "vendor/autoload.php";

use Diversen\ParallelProcess;

$async = new ParallelProcess();
$async->addProcess(function () {
    // posix_getpid(); // get the process id of the current process
    sleep(1);
    return 1;
});

$async->addProcess(function(){
    sleep(2);
    return 2;
    
});

$async->addProcess(function(){
    sleep(3);
    return 3;
});

$results = $async->run();
var_dump($results);

// Return codes of all the child processes
// array(3) {
//     [0]=>
//     int(1)
//     [1]=>
//     int(2)
//     [2]=>
//     int(3)
//   }

var_dump($async->getPids());  

// Pids of all the child processes
// Somthing like this:
// array(3) {
//     [0]=>
//     int(12903)
//     [1]=>
//     int(12904)
//     [2]=>
//     int(12905)
//   }
