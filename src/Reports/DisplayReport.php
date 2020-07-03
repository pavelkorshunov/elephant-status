<?php

namespace Elephant\Reports;

use Elephant\Contracts\Report;

class DisplayReport implements Report
{
    /**
     * @var string
     */
    private $display;

    /**
     * @param string $display
     */
    public function setDisplay(string $display): void
    {
        $this->display = $display;
    }

    public function generate()
    {
        echo $this->display;
    }


}