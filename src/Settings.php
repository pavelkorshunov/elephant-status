<?php

namespace Elephant;

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
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->prepareSettings($settings);
    }

    /**
     * @param array $settings
     */
    private function prepareSettings(array $settings)
    {
        $this->prepareUri($settings);

        if(!isset($settings['report']) && !isset($settings['parser'])) {
            $this->defaultSettings($settings);
        }
        // TODO доделать возможность выбирать парсер и форму отчета
    }

    /**
     * @param array $settings
     */
    private function prepareUri(array $settings)
    {
        if (!isset($settings['base_uri'])) {
            throw new \InvalidArgumentException('base_uri must be filled');
        }

        $validator = new UriValidator($settings['base_uri']);
        if(!$validator->valid()) {
            throw new \InvalidArgumentException('Unable to parse URI: '. $settings['base_uri']);
        }

        $this->settings['base_uri'] = $settings['base_uri'];
    }

    /**
     * @param array $settings
     */
    private function defaultSettings(array $settings)
    {
        $this->parser = !isset($settings['sitemap']) ?
            new SitemapParser() :
            new SitemapParser($settings['sitemap']);

        $this->report = new DisplayReport();
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
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
}