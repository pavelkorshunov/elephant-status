<?php

namespace Elephant\Tests;

use Elephant\Elephant;
use PHPUnit\Framework\TestCase;

class ElephantTest extends TestCase
{
    public function testIdentifyInvalidArgs()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('base_uri must be filled');

        new Elephant([]);
    }
}