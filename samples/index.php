<?php
require '../vendor/autoload.php';

use Elephant\Elephant;
use Elephant\Parser\SitemapParser;
use Elephant\Reports\DisplayReport;

// $report = new FileReport(__DIR__ . '/report.txt'); запись в файл
$report = new DisplayReport();

// sitemap.xml - путь к карте сайта. По умолчанию sitemap.xml, можно указать другой
// false - требуется ли проверять ссылки в карте сайта на соответствие base_uri.
// Если true, то ссылки в карте сайта вида http://www.foo.ru или http://www.site.com проверяться не будут
// 2 - количество ссылок которые требуется проверить. Если не требуется ограничивать ставим 0, проверит все ссылки. По умолчанию 0.
$sitemap = new SitemapParser('sitemap.xml', false, 2);

$elephant = new Elephant([
    'base_uri' => 'http://www.foo.com',
    'parser' => $sitemap,
    'report' => $report
]);

$elephant->generateReport();