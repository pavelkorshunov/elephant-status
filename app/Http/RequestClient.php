<?php

/*
 * Данный файл часть пакета Links Errors
 *
 * (c) Pavel Korshunov <info@hard-skills.ru>
 */

namespace App\Http;

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

    private function __clone() { }

    private function __construct() { }

    public static function getInstance()
    {
        if(null === self::$instance) {
            self::$instance = new Client([
                'base_uri' => BASE_URL
            ]);
            return self::$instance;
        }

        return self::$instance;
    }
}