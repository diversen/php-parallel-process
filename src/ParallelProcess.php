<?php

namespace Diversen;

use Exception;

class ParallelProcess
{

    private array $callbacks = [];
    private array $pids = [];

    public function __construct()
    {
        $this->callbacks = [];
    }

    /**
     * add a process to be run in parallel
     */
    public function addProcess(callable $command)
    {
        $this->callbacks[] = $command;
    }

    /**
     * run all callbacks
     */
    public function run(): array
    {   
        
        foreach ($this->callbacks as $callback) {
            $pid = pcntl_fork();
            if ($pid === -1) {
                throw new Exception("Could not fork a new process!");
            }
            if ($pid) {
                // Parent
                $this->pids[$pid] = true;
            } else {
                // Child
                $res = $callback();
                exit($res);
            }
        }
        
        // Parent
        $results = [];
        while (!empty($this->pids)) {

            // Wait for ANY child process to exit and return the pid of the child
            // That is what the -1 is for
            $pid = pcntl_waitpid(-1, $status);        
            if ($pid === -1) {
                throw new Exception("Error waiting for child process!");
            }
            if (isset($this->pids[$pid])) {
                unset($this->pids[$pid]);
                $status = pcntl_wexitstatus($status);
                $results[$pid] = $status;
            }
        }
        
        return $results;
    }
}
