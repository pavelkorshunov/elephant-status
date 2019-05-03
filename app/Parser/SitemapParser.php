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
        $body = (string) $response->getBody();

        $xmlList = [];

        try {
            $xml = new \SimpleXMLElement($body);

            if(0 !== $xml->count()) {

                foreach($xml->url as $nodeName => $nodeValue) {
                    $clearString = trim($nodeValue->loc->__toString());
                    array_push($xmlList, $clearString);
                }
            }

        } catch (\Exception $e) {
            echo $e;
        }

        return $xmlList;
    }
}