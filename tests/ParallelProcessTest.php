<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Diversen\ParallelProcess;

final class ParallelProcessTest extends TestCase
{

    public function test_simple(): void
    {
        $async = new ParallelProcess();
        $async->addProcess(function () {
            sleep(1);
            return 1;
        });
        $async->addProcess(function () {
            sleep(2);
            return 2;
        });

        $this->assertEquals(
            [1, 2],
            $async->run()
        );
    }
}
