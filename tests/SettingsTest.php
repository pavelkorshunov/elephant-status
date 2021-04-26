<?php

namespace Elephant\Tests;

use Elephant\Settings;
use Elephant\Parser\SitemapParser;
use Elephant\Reports\DisplayReport;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    public function testInvalidBaseUri()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to parse URI: ftp://foo.com');

        new Settings(['base_uri' => 'ftp://foo.com']);
    }

    public function testEmptyDefaultSettings()
    {
        $settings = new Settings(['base_uri' => 'https://example.com']);
        $default = $settings->getSettings();

        $this->assertArrayHasKey('report', $default);
        $this->assertArrayHasKey('parser', $default);
        $this->assertContainsOnlyInstancesOf(DisplayReport::class, [$default['report']]);
        $this->assertContainsOnlyInstancesOf(SitemapParser::class, [$default['parser']]);
    }
}