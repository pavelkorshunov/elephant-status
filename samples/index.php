<?php
require '../vendor/autoload.php';

use Elephant\Elephant;
use Elephant\Parser\SitemapParser;
use Elephant\Reports\DisplayReport;

// $report = new FileReport(__DIR__ . '/report.txt'); запись в файл
$report = new DisplayReport();

/*
    $sitemapPath = sitemap.xml - путь к карте сайта. По умолчанию sitemap.xml, можно указать другой.
    Необязательный по умолчанию sitemap.xml.

    $checkLinks = false - требуется ли проверять ссылки в карте сайта на соответствие base_uri.
    Если true, то ссылки в карте сайта вида http://www.foo.ru или http://www.site.com проверяться не будут
    Необязательный по умолчанию false.

    $sitemapFollow = true - требуется ли обходить другие ссылки карт сайта, если они нашлись в основном файле $sitemapPath
    Необязательный по умолчанию false.

    $maxLinks = 2 - количество ссылок которые требуется проверить. Если не требуется ограничивать ставим 0, тогда проверит все ссылки.
    Необязательный по умолчанию 0.
*/
$sitemap = new SitemapParser('sitemap.xml', false, true,20);

$elephant = new Elephant([
    'base_uri' => 'http://www.foo.com',
    'parser' => $sitemap,
    'report' => $report
]);

$elephant->generateReport();