<?php

namespace Elephant\Parser;

use Elephant\Contracts\Parser;
use Elephant\Http\RequestClient;
use GuzzleHttp\Exception\GuzzleException;

class SitemapParser implements Parser
{
    /**
     * Главный файл карты сайта
     *
     * @var string
     */
    private $sitemapPath;

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

    public function __construct(string $sitemapPath = 'sitemap.xml')
    {
        $this->sitemapPath = $sitemapPath;
    }

    /**
     * Отправляет запрос на получение тела карты сайта
     *
     * @throws GuzzleException
     * @return void
     */
    private function setHttpSitemapBody(): void
    {
        $path = "/" . $this->sitemapPath;
        $response = $this->client->request("GET", $path);
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
     * Парсинг карты сайта
     *
     * @throws GuzzleException
     * @return array
     */
    public function parse(): array
    {
        $this->setHttpSitemapBody();
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

    /**
     * @param RequestClient $client
     */
    public function setClient(RequestClient $client): void
    {
        $this->client = $client;
    }
}