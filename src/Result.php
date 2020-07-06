<?php

namespace Elephant;

use Elephant\Contracts\ResultInterface;

class Result implements ResultInterface
{
    /**
     * @var string
     */
    protected $sitemapFile;

    /**
     * @var array
     */
    protected $links = [];

    /**
     * @var array
     */
    protected $codes = [];

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param string $link
     */
    public function addLink(string $link): void
    {
        array_push($this->links, $link);
    }

    /**
     * @return array
     */
    public function getCodes(): array
    {
        return $this->codes;
    }

    /**
     * @param string|int $code
     */
    public function addCode($code): void
    {
        array_push($this->codes, $code);
    }

    /**
     * @return string
     */
    public function getSitemapFile(): string
    {
        return $this->sitemapFile;
    }

    /**
     * @param string $sitemapFile
     */
    public function setSitemapFile(string $sitemapFile): void
    {
        $this->sitemapFile = $sitemapFile;
    }
}