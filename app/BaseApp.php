<?php

namespace App;

use GuzzleHttp\Client;

class BaseApp
{
    public $url;
    public $application;

    /**
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->setUrl($url);
    }

    /**
     * Set url
     *
     * @param string $path
     * @return void
     */
    public function setUrl(string $path)
    {
        $this->url = $path;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     *
     */
    public function start()
    {
        $client = new Client([
            "base_uri" => $this->url
        ]);

        $this->application = $client->request("GET");
    }
}