<?php

namespace Elephant\Reports;

use Elephant\Contracts\Report;
use Elephant\Http\RequestClient;

class DisplayReport implements Report
{
    // TODO переделать метод. Класс не должен заниматься отправкой запросов
    public function generate($links)
    {
        $client = RequestClient::getInstance();

        foreach ($links as $linkCount => $slink) {
            if ($linkCount < 2) {
                $response = $client->get($slink, ['http_errors' => false]);

                echo $slink . "<br>";
                echo $response->getStatusCode() . "<br>";

            }
        }
    }
}