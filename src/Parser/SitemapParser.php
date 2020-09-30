<?php

namespace Elephant\Parser;

use Elephant\Result;
use Elephant\Http\RequestClient;
use Elephant\Validator\UriValidator;
use GuzzleHttp\Exception\GuzzleException;
use Elephant\Contracts\{
    ParserInterface,
    ResultInterface,
    SettingsInterface
};

class SitemapParser implements ParserInterface
{
    /**
     * Количество проверенных ссылок
     *
     * @var int
     */
    protected $linksCheck = 0;

    /**
     * Ссылки на файлы карт сайта
     *
     * @var array
     */
    protected $sitemapFiles = [];

    /**
     * Главный файл карты сайта
     *
     * @var string
     */
    protected $sitemapPath;

    /**
     * Объект клиента
     *
     * @var RequestClient
     */
    protected $client;

    /**
     * Объект настроек
     *
     * @var SettingsInterface
     */
    protected $settings;

    /**
     * Тело карты сайта
     *
     * @var string
     */
    protected $sitemapBody;

    /**
     * Указывает требуется ли сравнивать ссылки в карте сайта с текущим хостом
     *
     * @var bool
     */
    protected $checkLinks;

    /**
     * Указывает максимальное количество ссылок которое будет проверено. 0 - без ограничений
     *
     * @var int
     */
    protected $maxLinks;

    /**
     * Указывает нужно ли дополнительно проваливаться по ссылкам с расширением .xml
     *
     * @var bool
     */
    protected $sitemapFollow;

    /**
     * @param string $sitemapPath
     * @param bool $checkLinks
     * @param bool $sitemapFollow
     * @param int $maxLinks
     */
    public function __construct(string $sitemapPath = 'sitemap.xml', bool $checkLinks = false, bool $sitemapFollow = false, int $maxLinks = 0)
    {
        $this->sitemapPath = $sitemapPath;
        $this->checkLinks = $checkLinks;
        $this->sitemapFollow = $sitemapFollow;

        if($maxLinks < 0) {
            $maxLinks = 0;
        }
        $this->maxLinks = $maxLinks;
    }

    /**
     * Отправляет запрос на получение тела карты сайта
     *
     * @throws GuzzleException
     * @return void
     */
    protected function setHttpSitemapBody(): void
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
    protected function isXmlUrl(string $url) : bool
    {
        $xml = explode('.', $url);
        return array_pop($xml) === "xml";
    }

    /**
     * Проверяет что строка является ссылкой
     *
     * @param string $link
     * @return bool
     */
    protected function checkLink(string $link)
    {
        if($this->checkLinks && !$this->fullCheck($link)) {
            return false;
        } elseif (!$this->checkLinks && !$this->simpleCheck($link)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $link
     * @return bool
     */
    protected function fullCheck(string $link)
    {
        $settings = $this->settings->getSettings();
        $url = parse_url($settings['base_uri']);
        $validator = new UriValidator($link, $url['host']);

        if($validator->validByHost()) {
            return true;
        }

        return false;
    }

    /**
     * @param string $link
     * @return bool
     */
    protected function simpleCheck(string $link)
    {
        $validator = new UriValidator($link);

        if($validator->valid()) {
            return true;
        }

        return false;
    }

    /**
     * @param string|bool $sitemapBody
     * @param ResultInterface $result
     * @return ResultInterface
     * @throws GuzzleException
     */
    protected function round(string $sitemapBody, ResultInterface $result)
    {
        //TODO сделать рефакторинг этого метода + попробовать улучшить проход по ссылкам. Вероятно сделать очередь или использовать поток php://temp
        $xml = new \SimpleXMLElement($sitemapBody);

        if(0 === $xml->count()) {
            return $result;
        }

        foreach($xml->children() as $nodeName => $nodeValue) {

            if(!isset($nodeValue->loc)) {
                continue;
            }

            $link = trim($nodeValue->loc->__toString());

            if(!$this->checkLink($link)) {
                continue;
            }

            if($this->isXmlUrl($link) && $this->sitemapFollow) {
                array_push($this->sitemapFiles, $link);
            }

            if($this->maxLinks > 0 && $this->linksCheck >= $this->maxLinks) {
                break;
            }

            if(!$this->isXmlUrl($link)) {
                $response = $this->client->get($link, ['http_errors' => false, 'allow_redirects' => false]);
                $result->addLink($link);
                $result->addCode($response->getStatusCode());
                $this->linksCheck++;
            }
        }

        if($this->sitemapFollow && count($this->sitemapFiles) > 0) {

            $path = array_shift($this->sitemapFiles);
            $response = $this->client->request("GET", $path);
            $localSitemapBody = (string) $response->getBody();

            return $this->round($localSitemapBody, $result);
        }

        return $result;
    }

    /**
     * Парсинг карты сайта
     *
     * @param RequestClient $client
     * @param SettingsInterface $settings
     * @return ResultInterface
     * @throws GuzzleException
     */
    public function parse(RequestClient $client, SettingsInterface $settings): ResultInterface
    {
        $this->client = $client;
        $this->settings = $settings;
        $this->setHttpSitemapBody();

        $result = new Result();
        $result->setSitemapFile($this->sitemapPath);

        return $this->round($this->sitemapBody, $result);
    }
}