<?php

namespace Elephant\Parser;

use Elephant\Contracts\Parser;

class LinkParser implements Parser
{
    /**
     * Содержит список всех ссылок в виде объекта \DOMNodeList
     *
     * @var \DOMNodeList
     */
    private $links;

    /**
     * Массив всех ссылок с анкорами и контентом
     *
     * @var array
     */
    public $linksData = [];

    /**
     * Инициализация параметров
     *
     * @param string $html
     * @return void
     */
    public function __construct(string $html)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $this->links = $dom->getElementsByTagName('a');
    }

    /**
     * Возвращает текст ссылки или false если у ссылки текст отсутствует
     *
     * @param \DOMNodeList object $domLink
     * @return mixed
     */
    public function getTextContent($domLink)
    {
        $linkText = trim($domLink->textContent);
        if(empty($linkText)) {
            return false;
        }
        return $linkText;
    }

    /**
     * Возвращает анкор ссылки либо false
     *
     * @param \DOMNodeList object $domLink
     * @return mixed
     */
    public function getAttrHref($domLink)
    {
        $href = $domLink->getAttribute('href');
        if(empty($href)) {
            return false;
        }
        return $href;
    }

    /**
     * Производит парсинг всех ссылок на странице и возвращает массив с их содержимым
     *
     * @return array
     */
    public function parseAll(): array
    {
        foreach ($this->links as $count => $link) {
            $linkData = [
                "content" => trim($link->textContent),
                "href" => $link->getAttribute('href')
            ];

            $this->linksData[$count] = $linkData;
        }

        return $this->linksData;
    }

    /**
     * Возвращает массив ссылок только с существующим анкором, пустые ссылки удаляются
     *
     * @return array
     */
    public function parse(): array
    {
        $this->parseAll();

        $filtered = array_filter($this->linksData, function($value){
            $clear = str_one_spacing($value['content']);
            return $clear;
        });

        foreach ($filtered as $key => $filter) {
            $filtered[$key]['content'] = str_one_spacing($filter['content']);
        }

        return $filtered;
    }
}