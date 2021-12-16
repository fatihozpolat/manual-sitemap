<?php

namespace FatihOzpolat\Sitemap\Tags;

class Alternate
{
    public string $locale;
    public string $url;

    public static function create(string $url, string $locale = ''): self
    {
        return new static($url, $locale);
    }

    public function __construct(string $url, $locale = '')
    {
        $this->setUrl($url);

        $this->setLocale($locale);
    }

    public function setLocale(string $locale = ''): Alternate
    {
        $this->locale = $locale;

        return $this;
    }

    public function setUrl(string $url = ''): Alternate
    {
        $this->url = $url;

        return $this;
    }
}
