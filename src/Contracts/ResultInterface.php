<?php

namespace Elephant\Contracts;

interface ResultInterface
{
    public function getLinks(): array;

    public function getCodes(): array;
}
