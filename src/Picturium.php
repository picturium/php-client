<?php

namespace Picturium;

use RuntimeException;

class Picturium
{
    protected static $instances = [];

    protected string $src;

    protected array $instance;

    /**
     * @var PicturiumImage[]
     */
    protected array $images = [];

    public function __construct(string $src, ?string $instance = null)
    {
        $this->src = $src;

        $instance = $instance ?? (array_key_first(self::$instances) ?? null);

        if (!$instance || !isset(self::$instances[$instance])) {
            throw new RuntimeException('No instances matching "' . ($instance ?? "null") . '" were configured!');
        }

        $this->instance = self::$instances[$instance];
    }

    public function getInstance(): array
    {
        return $this->instance;
    }

    public function getSrc(): string
    {
        return $this->src;
    }

    public function add(PicturiumImage $image): self
    {
        $this->images[] = $image;

        return $this;
    }

    public function src(): string
    {
        return PicturiumImage::create()->src($this->src, null, $this);
    }

    /**
     * @return array<int,array<string,string>>
     */
    public function sources(): array
    {
        $result = [];

        foreach ($this->images as $image) {
            $result[] = [
                "media" => $image->media(),
                "src" => $image->src($this->src, null, $this),
                "srcset" => $image->srcset($this->src, null, $this),
            ];
        }

        return $result;
    }

    public static function configure(string $name, string $url, ?string $token = null): void
    {
        self::$instances[$name] = [
            "url" => $url,
            "token" => $token,
        ];
    }
}
