<?php

namespace Picturium;

use Picturium\Picturium;
use RuntimeException;

class PicturiumImage
{
    protected ?string $src = null;

    protected int $minWidth = 0;

    protected ?int $width = null;

    protected ?int $height = null;

    protected ?string $aspectRatio = null;

    protected string|int|null $quality = null;

    protected int $maxDPR = 2;

    protected ?array $crop = null;

    protected ?array $load = null;

    protected ?array $thumb = null;

    protected bool $original = false;

    protected ?int $rotate = null;

    protected ?string $background = null;

    protected ?string $format = null;

    public function __construct(?string $src = null)
    {
        $this->src = $src;
    }

    public function minWidth(int $width): self
    {
        $this->minWidth = max(0, $width);
        return $this;
    }

    public function width(int $width): self
    {
        $this->width = max(0, $width) ?: null;
        return $this;
    }

    public function height(int $height): self
    {
        $this->height = max(0, $height) ?: null;
        return $this;
    }

    public function aspectRatio(string $aspectRatio): self
    {
        if (!AspectRatio::validate($aspectRatio)) {
            $aspectRatio = null;
        }

        $this->aspectRatio = $aspectRatio;
        return $this;
    }

    public function quality(string|int $quality): self
    {
        if (!in_array($quality, Quality::ALLOWED_VALUES, true) && !is_numeric($quality)) {
            $quality = null;
        } elseif (is_numeric($quality)) {
            $quality = min(max(0, $quality), 100);
        }

        $this->quality = $quality;
        return $this;
    }

    public function maxDPR(int $dpr): self
    {
        $dpr = max(1, $dpr);
        $dpr = min($dpr, 4);

        $this->maxDPR = $dpr;
        return $this;
    }

    public function crop(
        ?int $width = null,
        ?int $height = null,
        ?string $aspectRatio = null,
        ?string $gravity = null,
        ?int $offsetX = null,
        ?int $offsetY = null
    ): self {
        if ((int) $width <= 0 && (int) $height <= 0) {
            throw new RuntimeException("Crop function requires at least one of width or height parameters to be set!");
        }

        $width = max(0, (int) $width) ?: null;
        $height = max(0, (int) $height) ?: null;

        if (!AspectRatio::validate($aspectRatio)) {
            $aspectRatio = null;
        }

        if (!in_array($gravity, Gravity::ALLOWED_VALUES, true)) {
            $gravity = null;
        }

        $this->crop = [
            "width" => $width,
            "height" => $height,
            "aspectRatio" => $aspectRatio,
            "gravity" => $gravity,
            "offsetX" => $offsetX,
            "offsetY" => $offsetY,
        ];

        return $this;
    }

    public function load(?int $dpi = null): self
    {
        $dpi = min(max(0, $dpi), 3000) ?: null;

        $this->load = [
            "dpi" => $dpi,
        ];

        return $this;
    }

    public function thumb(?int $page = null): self
    {
        $page = max(0, $page) ?: null;

        $this->thumb = [
            "page" => $page,
        ];

        return $this;
    }

    public function original(bool $original = true): self
    {
        $this->original = $original;
        return $this;
    }

    public function rotate(int $rotate): self
    {
        if (!in_array($rotate, Rotate::ALLOWED_VALUES, true)) {
            $rotate = null;
        }

        $this->rotate = $rotate;
        return $this;
    }

    public function background(string $color): self
    {
        if (!Color::validate($color)) {
            $color = null;
        }

        $this->background = $color;
        return $this;
    }

    public function format(string $format): self
    {
        if (!in_array($format, Format::ALLOWED_VALUES, true)) {
            $format = null;
        }

        $this->format = $format;
        return $this;
    }

    public static function create(
        ?string $src = null,
        int $minWidth = 0,
        ?int $width = null,
        ?int $height = null,
        ?string $aspectRatio = null,
        string|int|null $quality = null,
        ?int $dpr = null,
        ?array $crop = null,
        ?array $load = null,
        ?array $thumb = null,
        bool $original = false,
        ?int $rotate = null,
        ?string $background = null,
        ?string $format = null
    ): self {
        $image = new self($src);

        $image->minWidth($minWidth);
        $image->width($width);
        $image->height($height);
        $image->original($original);

        if (isset($aspectRatio)) {
            $image->aspectRatio($height);
        }

        if (isset($quality)) {
            $image->quality($quality);
        }

        if (isset($dpr)) {
            $image->maxDPR($dpr);
        }

        if (isset($crop)) {
            $image->crop(
                $crop["width"] ?? null,
                $crop["height"] ?? null,
                $crop["aspectRatio"] ?? null,
                $crop["gravity"] ?? null,
                $crop["offsetX"] ?? null,
                $crop["offsetY"] ?? null
            );
        }

        if (isset($load)) {
            $image->load($load["dpi"] ?? null);
        }

        if (isset($thumb)) {
            $image->thumb($thumb["page"] ?? null);
        }

        if (isset($rotate)) {
            $image->rotate($rotate);
        }

        if (isset($background)) {
            $image->background($background);
        }

        if (isset($format)) {
            $image->format($format);
        }

        return $image;
    }

    public function media(): string
    {
        return "(min-width: {$this->minWidth}px)";
    }

    public function src(?string $src = null, ?string $instance = null, ?Picturium $picturium = null): string
    {
        $picturium = $this->getPicturiumInstance($src, $instance, $picturium);
        return (new UrlGenerator($picturium))->generateUrl($this->serialize());
    }

    public function srcset(?string $src = null, ?string $instance = null, ?Picturium $picturium = null): string
    {
        $picturium = $this->getPicturiumInstance($src, $instance, $picturium);
        $srcset = [];

        foreach (range(1, $this->maxDPR) as $dpr) {
            $srcset[] = (new UrlGenerator($picturium))->generateUrl($this->serialize($dpr)) . " " . $dpr . "x";
        }

        return implode(", ", $srcset);
    }

    /**
     * @return array<string,mixed>
     */
    public function serialize(?int $dpr = null): array
    {
        if ($dpr === 1) {
            $dpr = null;
        }

        return [
            "src" => $this->src,
            "w" => $this->width,
            "h" => $this->height,
            "ar" => $this->aspectRatio,
            "q" => $this->quality,
            "crop" => $this->crop,
            "load" => $this->load,
            "thumb" => $this->thumb,
            "original" => $this->original,
            "rot" => $this->rotate,
            "bg" => $this->background,
            "f" => $this->format,
            "dpr" => $dpr,
        ];
    }

    protected function getPicturiumInstance(
        ?string $src = null,
        ?string $instance = null,
        ?Picturium $picturium = null
    ): Picturium {
        $this->src = $src ?? $this->src;

        if (empty($this->src)) {
            throw new RuntimeException("Please, provide image source!");
        }

        return $picturium ?? new Picturium($this->src, $instance);
    }
}
