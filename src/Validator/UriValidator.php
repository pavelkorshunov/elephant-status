<?php

namespace Elephant\Validator;

use Elephant\Contracts\ValidatorInterface;

class UriValidator implements ValidatorInterface
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
     * @param string $url
     * @return void
     */
    public function __construct(string $url, string $host = '')
    {
        $this->url = $url;
        $this->host = $host;

        if($url != '') {
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
     * Проверяет url на валидность и соответствие текущему хосту
     *
     * @return bool
     */
    public function validByHost()
    {
        if(
            $this->parseUrl !== null
            && isset($this->parseUrl["scheme"])
            && $this->isHttp($this->parseUrl["scheme"])
            && isset($this->parseUrl["host"])
            && $this->parseUrl["host"] === $this->host
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