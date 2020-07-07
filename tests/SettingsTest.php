<?php

namespace Elephant\Tests;

use Elephant\Settings;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    public function testInvalidBaseUri()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Settings(['base_uri' => 'ftp://foo.com']);
    }
}