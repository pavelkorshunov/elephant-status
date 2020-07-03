<?php

namespace Elephant;

class Elephant
{
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
    }

    public function generateReport()
    {
        $links = $this->setting->getParser()->parse();
        $this->setting->getReport()->generate($links);
    }
}