<?php

namespace Diversen;

use Exception;

class ParallelProcess
{

    private $processes = [];
    private $results = [];
    private $pids = [];

    public function __construct()
    {
        $this->processes = [];
    }

    /**
     * add a process to be run in parallel
     */
    public function addProcess(callable $command)
    {
        $this->processes[] = $command;
    }

    /**
     * run all processes
     */
    public function run(): array
    {
        $processes = $this->processes;
        $this->processes = [];

        foreach ($processes as $command) {
            $pid = pcntl_fork();
            if ($pid === -1) {
                throw new Exception("Could not fork a new process!");
            }
            if ($pid) {
                $this->pids[] = $pid;
            } else {
                $res = $command();
                exit($res);
            }
        }

        while (pcntl_waitpid(0, $status) != -1) {
            $status = pcntl_wexitstatus($status);
            $this->results[] = $status;
        }

        return $this->results;
    }


    /**
     * return all child process ids
     */
    public function getPids(): array
    {
        return $this->pids;
    }
}
