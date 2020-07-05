<?php
require '../vendor/autoload.php';

use Elephant\Elephant;
use Elephant\Parser\SitemapParser;
use Elephant\Reports\DisplayReport;

$report = new DisplayReport();
$sitemap = new SitemapParser('sitemap.xml', false, 2);

$elephant = new Elephant([
    'base_uri' => 'https://hard-skills.ru',
    'parser' => $sitemap,
    'report' => $report
]);

$elephant->generateReport();