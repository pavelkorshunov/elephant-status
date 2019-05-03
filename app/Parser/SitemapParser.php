<?php

namespace App\Parser;

use App\Contracts\Parser;
use App\Http\RequestClient;

class SitemapParser implements Parser
{
    /**
     * Главный файл карты сайта
     *
     * @var string
     */
    private $sitemapPath = "/sitemap.xml";

    /**
     * Объект клиента
     *
     * @var RequestClient
     */
    private $client;

    public function __construct()
    {
        $this->client = RequestClient::getInstance();
    }

    /**
     *
     *
     */
    public function parse(): array
    {
        $response = $this->client->request("GET", $this->sitemapPath);
        $body = $response->getBody();

        try {
            $xml = new \SimpleXMLElement($body);

            $xmlList = [];
            foreach ($xml->url as $element) {
                array_push($xmlList, $element->loc);
                print_r(gettype($element->loc));
            }

            return $xmlList;

        } catch (\Exception $e) {
            echo $e;
        }

        return [];
        // TODO: Implement parse() method.
    }
}