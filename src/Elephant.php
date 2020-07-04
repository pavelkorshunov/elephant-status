<?php

namespace Elephant;

use Elephant\Contracts\ParserInterface;
use Elephant\Contracts\ReportInterface;
use Elephant\Http\RequestClient;

class Elephant
{
    /**
     * @var RequestClient
     */
    private $client;

    /**
     * @var Settings
     */
    private $setting;

    /**
     * Пример создания класса с использованием base_uri и массива опций
     *
     *    $elephant = new Client([
     *        'base_uri'        => 'http://www.foo.com/',
     *        'parser'          => new SitemapParser('sitemap.xml', false, 0),
     *        'report'          => new DisplayReport()
     *    ]);
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->setting = new Settings($settings);
        $this->client = new RequestClient($this->setting->getSettings());
    }

    public function generateReport()
    {
        $checkSettings = $this->setting->getSettings();
        $parser = $checkSettings['parser'];
        $report = $checkSettings['report'];

        if($parser instanceof ParserInterface) {
            $data = $parser->parse($this->client, $this->setting);
        } else {
            throw new \LogicException('ParserInterface not implements for object ' . $parser);
        }

        if($report instanceof ReportInterface) {
            $report->generate($data);
        }
        else {
            throw new \LogicException('ReportInterface not implements for object ' . $report);
        }
    }
}