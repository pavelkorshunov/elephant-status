<?php

namespace Elephant\Reports;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Elephant\Contracts\{
    ReportInterface,
    ResultInterface
};

class DisplayReport implements ReportInterface
{
    public function generate(ResultInterface $result)
    {
        $loader = new FilesystemLoader(__DIR__ . '/resources/views');
        $twig = new Environment($loader);

        $sitemap = (
            method_exists($result, 'getSitemapFile')
            && $result->getSitemapFile() !== null
        ) ? $result->getSitemapFile() : null;

        $links = $result->getLinks();
        $codes = $result->getCodes();

        echo $twig->render('layout.html.twig', compact('links', ['codes', 'sitemap']));
    }
}