<?php

namespace Elephant\Reports;

use Elephant\Contracts\{
    ReportInterface,
    ResultInterface
};

class DisplayReport implements ReportInterface
{
    public function generate(ResultInterface $result)
    {
        $links = $result->getLinks();
        $codes = $result->getCodes();

        if(empty($links)) {
            echo 'No links were found in the sitemap';
        } else {

            $reportText = '';

            if(method_exists($result, 'getSitemapFile') && $result->getSitemapFile() !== null) {
                $reportText .= sprintf('Sitemap file: %s <br><br>', $result->getSitemapFile());
            }

            foreach ($links as $key => $link) {

                $reportText .= sprintf('%s <br> %s <br>', $link, $codes[$key]);
            }

            echo $reportText;
        }
    }
}