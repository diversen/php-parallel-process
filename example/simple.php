<?php

require_once "vendor/autoload.php";

use Diversen\ParallelProcess;

$parallel = new ParallelProcess();
$parallel->addProcess(function () {
    // posix_getpid(); // get the process id of the current process
    sleep(1);
    return 1;
});

$parallel->addProcess(function(){
    sleep(2);
    return 2;
    
});

$parallel->addProcess(function(){
    sleep(3);
    return 3;
});

$results = $parallel->run();
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

var_dump($parallel->getPids());  

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
