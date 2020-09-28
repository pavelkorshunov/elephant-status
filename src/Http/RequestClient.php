<?php

/*
 * Данный файл часть пакета ElephantStatus
 *
 * (c) Pavel Korshunov <info@hard-skills.ru>
 */

namespace Elephant\Http;

use GuzzleHttp\Client;

/**
 * @author Pavel Korshunov <info@hard-skills.ru>
 */

final class RequestClient extends Client
{
    public function __construct(array $setting, array $config = [])
    {
        $localConfig = array_merge(['base_uri' => $setting['base_uri']], $config);
        parent::__construct($localConfig);
    }
}