<?php

namespace FatihOzpolat\Sitemap;

use FatihOzpolat\Sitemap\Tags\Tag;
use FatihOzpolat\Sitemap\Tags\Url;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class Sitemap implements Responsable
{
    protected array $tags = [];

    public static function create(): self
    {
        return new static();
    }

    public function add($tag): self
    {
        if (is_iterable($tag)) {
            foreach ($tag as $t) {
                $this->add($t);
            }

            return $this;
        }

        if (is_string($tag)) {
            $tag = Url::create($tag);
        }

        if (!in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getUrl(string $url): ?Url
    {
        return collect($this->tags)->first(function (Tag $tag) use ($url) {
            return $tag->getType() === 'url' && $tag->url === $url;
        });
    }

    public function hasUrl(string $url): bool
    {
        return (bool)$this->getUrl($url);
    }

    public function render(): string
    {
        sort($this->tags);

        $tags = collect($this->tags)->unique('url');

        return view('manual-sitemap::sitemap')
            ->with(compact('tags'))
            ->render();
    }

    public function writeToFile(string $path): self
    {
        file_put_contents($path, $this->render());

        return $this;
    }

    public function writeToDisk(string $disk, string $path): self
    {
        Storage::disk($disk)->put($path, $this->render());

        return $this;
    }

    public function toResponse($request): \Symfony\Component\HttpFoundation\Response
    {
        return Response::make($this->render(), 200, [
            'Content-Type' => 'text/xml',
        ]);
    }
}
