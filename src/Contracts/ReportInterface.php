<?php

namespace Elephant\Contracts;

interface ReportInterface
{
    public function generate(string $data);
}