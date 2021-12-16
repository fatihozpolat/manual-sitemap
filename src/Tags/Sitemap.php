<?php

namespace FatihOzpolat\Sitemap\Tags;

use Carbon\Carbon;
use DateTime;

class Sitemap extends Tag
{
    /** @var string */
    public string $url = '';

    /** @var Carbon */
    public Carbon $lastModificationDate;

    public static function create(string $url): self
    {
        return new static($url);
    }

    public function __construct(string $url)
    {
        $this->url = $url;

        $this->lastModificationDate = Carbon::now();
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl(string $url = ''): Sitemap
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param DateTime $lastModificationDate
     *
     * @return $this
     */
    public function setLastModificationDate(DateTime $lastModificationDate): Sitemap
    {
        $this->lastModificationDate = $lastModificationDate;

        return $this;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return parse_url($this->url)['path'] ?? '';
    }
}
