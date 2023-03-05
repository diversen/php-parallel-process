<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Diversen\ParallelProcess;

final class ParallelProcessTest extends TestCase
{

    public function test_simple(): void
    {
        $parallel = new ParallelProcess();
        $parallel->addProcess(function () {
            try {
                throw new Exception('Test');
            } catch (Exception $e) {
                return 1;
            }
        });
        $parallel->addProcess(function () {
            sleep(1);
            return 2;
        });

        $this->assertEquals(
            [1, 2],
            $parallel->run()
        );
    }
}
