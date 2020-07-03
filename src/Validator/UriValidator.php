<?php

namespace Elephant\Validator;

use Elephant\Contracts\Validator;

class UriValidator implements Validator
{
    /**
     * Host
     *
     * @var string
     */
    protected $host;

    /**
     * Строка содержащая url
     *
     * @var string
     */
    protected $url;

    /**
     * @var array|false|int|string|null
     */
    protected $parseUrl;

    /**
     * Конструктор заполняет параметры
     *
     * @param string $host
     * @param string $uri
     * @return void
     */
    public function __construct(string $uri, string $host = "")
    {
        $this->url = $uri;
        $this->host = $host;

        if($uri != '') {
            $this->parseUrl = parse_url($this->url);
        }
    }

    /**
     * Проверяет на соответствие протоколу http или https
     *
     * @param string $scheme
     * @return bool
     */
    protected function isHttp(string $scheme): bool
    {
        return false !== strpos($scheme, 'http') || false !== strpos($scheme, 'https');
    }

    /**
     * Проверяет url на валидность
     *
     * @return bool
     */
    public function valid(): bool
    {
        if(
            $this->parseUrl !== null
            && isset($this->parseUrl["host"])
            && isset($this->parseUrl["scheme"])
            && $this->isHttp($this->parseUrl["scheme"])
        ) {
            return true;
        }

        return false;
    }

    /**
     * Удаляет все повторяющиеся ссылки в массиве
     *
     * @param array $repeat
     * @return array
     */
    public static function uniqueUrl(array $repeat): array
    {
        // TODO убрать из массива ссылки вида /club_cards и /club_cards/
        $unique = [];

        foreach ($repeat as $item) {
            if(!in_array($item, $unique) && $item !== "/") {
                array_push($unique, $item);
            }
        }
        return $unique;
    }
}