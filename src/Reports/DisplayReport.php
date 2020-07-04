<?php

namespace Elephant\Reports;

use Elephant\Contracts\ReportInterface;

class DisplayReport implements ReportInterface
{
    // TODO Сделать вместо строки объект результата в котором будут ссылки и их коды ответа
    public function generate(string $data)
    {
        echo $data;
    }
}