<?php

namespace Elephant;

use Elephant\Contracts\SettingsInterface;
use Elephant\Parser\SitemapParser;
use Elephant\Reports\DisplayReport;
use Elephant\Validator\UriValidator;

class Settings implements SettingsInterface
{
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

        if(!isset($settings['report']) || !isset($settings['parser'])) {
            $this->defaultSettings($settings);
        } else {
            $this->settings = array_merge($this->settings, $settings);
        }
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
     * @return void
     */
    private function defaultSettings(array $settings)
    {
        $this->settings['report'] = $settings['report'] ?? new DisplayReport();
        $this->settings['parser'] = $settings['parser'] ?? new SitemapParser();
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }
}