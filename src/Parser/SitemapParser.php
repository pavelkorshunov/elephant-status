<?php

namespace Elephant\Parser;

use Elephant\Contracts\Parser;
use Elephant\Http\RequestClient;

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

    /**
     * Тело карты сайта
     *
     * @var string
     */
    private $sitemapBody;

    /**
     *
     *
     */
    public function __construct()
    {
        $this->client = RequestClient::getInstance();
    }

    /**
     * Отправляет запрос на получение тела карты сайта
     *
     *
     */
    private function sendRequest()
    {
        // TODO бросить исключение
        $response = $this->client->request("GET", $this->sitemapPath);
        $this->sitemapBody = (string) $response->getBody();
    }

    /**
     * Проверяет является ли url xml файлом
     *
     * @param string $url
     * @return boolean
     */
    public function isXmlUrl(string $url) : bool
    {
        $xml = strstr($url, ".xml");
        if($xml === ".xml") {
            return true;
        }
        return false;
    }

    /**
     *
     *
     */
    public function parse(): array
    {
        $this->sendRequest();
        $xmlList = [];

        try {
            $xml = new \SimpleXMLElement($this->sitemapBody);

            if(0 !== $xml->count()) {

                foreach($xml->url as $nodeName => $nodeValue) {
                    $clearString = trim($nodeValue->loc->__toString());
                    array_push($xmlList, $clearString);
                }
            }

        } catch (\Exception $e) {
            // TODO normal Exception
            echo $e;
        }

        return $xmlList;
    }
}