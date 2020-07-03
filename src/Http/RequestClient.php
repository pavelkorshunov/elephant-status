<?php

/*
 * Данный файл часть пакета Links Errors
 *
 * (c) Pavel Korshunov <info@hard-skills.ru>
 */

namespace Elephant\Http;

use GuzzleHttp\Client;

/**
 * Объект класса запроса по принципу шаблона Singleton
 *
 * @author Pavel Korshunov <info@hard-skills.ru>
 */

final class RequestClient
{
    /**
     * Объект клиента
     *
     * @var Client
     */
    private static $instance;

    private static $baseUrl;

    private function __clone() { }

    private function __construct() { }

    /**
     * @return Client
     */
    public static function getInstance()
    {
        if(self::$instance === null) {

            self::$instance = new Client([
                'base_uri' => self::$baseUrl
            ]);

            return self::$instance;
        }

        return self::$instance;
    }

    // TODO подумать как улучшить, чтобы не устанавливать урл сайта здесь
    public static function setBaseUrl($url)
    {
        self::$baseUrl = $url;
    }
}