<?php

namespace Elephant\Contracts;

use Elephant\Http\RequestClient;

interface ParserInterface
{
    public function parse(RequestClient $client, SettingsInterface $settings): string;
}