<?php

namespace Elephant\Reports;

use Elephant\Contracts\{
    ReportInterface,
    ResultInterface
};

class FileReport implements ReportInterface
{
    private $filePath;

    public function __construct(string $path)
    {
        $this->filePath = $path;
    }

    public function generate(ResultInterface $result)
    {
        $links = $result->getLinks();
        $codes = $result->getCodes();

        if(empty($links)) {
            file_put_contents($this->filePath, 'Links not found');
        } else {
            $reportText = '';

            if(method_exists($result, 'getSitemapFile') && $result->getSitemapFile() !== null) {
                $reportText .= sprintf("Sitemap file: %s \r\n\r\n", $result->getSitemapFile());
            }

            foreach ($links as $key => $link) {

                $reportText .= sprintf("%s\r\n%s\r\n", $link, $codes[$key]);
            }

            file_put_contents($this->filePath, $reportText);
        }
    }
}