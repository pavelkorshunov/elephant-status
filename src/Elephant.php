<?php

namespace Elephant;

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
     * Elephant constructor.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->setting = new Settings($settings);
        $this->client = new RequestClient($this->setting->getSettings());
    }

    public function generateReport()
    {
        $display = '';
        $parser = $this->setting->getParser();

        // TODO подумать как улучшить у класса LinkParser нет сеттера вероятно надо вынести создание классов из метода класса Settings::defaultSettings
        $parser->setClient($this->client);

        $links = $parser->parse();

        foreach ($links as $linkCount => $slink) {

            if ($linkCount < 2) {
                $response = $this->client->get($slink, ['http_errors' => false]);

                $display .= $slink . '<br>';
                $display .= $response->getStatusCode() . '<br>';
            }
        }

        $report = $this->setting->getReport();

        // TODO подумать как улучшить у класса FileReport нет сеттера
        $report->setDisplay($display);
        $report->generate();
    }
}