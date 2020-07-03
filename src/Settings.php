<?php

namespace Elephant;

use Elephant\Http\RequestClient;
use Elephant\Parser\SitemapParser;
use Elephant\Reports\DisplayReport;
use Elephant\Validator\UriValidator;
use Elephant\Contracts\{
    Report,
    Parser
};

class Settings
{
    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var Report
     */
    private $report;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var array
     */
    private $settings;

    /**
     * Settings constructor.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->requiredSettings($settings);
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * @param string $host
     */
    public function setBaseUri(string $host): void
    {
        $this->baseUri = $host;
    }

    /**
     * @return Parser
     */
    public function getParser(): Parser
    {
        return $this->parser;
    }

    /**
     * @return Report
     */
    public function getReport(): Report
    {
        return $this->report;
    }

    /**
     * @param array $settings
     */
    public function requiredSettings(array $settings)
    {
        $this->settings = $settings;

        // TODO использовать UriValidator
        if (isset($this->settings['base_uri'])) {
            $this->setBaseUri($this->settings['base_uri']);
        }

        $this->baseUriInit();

        // TODO доделать возможность выбирать парсер и форму отчета
        $this->report = new DisplayReport();
        $this->parser = new SitemapParser();
    }

    private function baseUriInit()
    {
        RequestClient::setBaseUrl($this->baseUri);
    }
}