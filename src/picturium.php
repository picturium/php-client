<?php

use Picturium\Picturium;
use Picturium\PicturiumImage;

if (!function_exists("pic")) {
    function pic(string $src, ?string $instance = null): Picturium
    {
        return new Picturium($src, $instance);
    }
}

if (!function_exists("img")) {
    function img(
        ?string $src = null,
        int $minWidth = 0,
        ?int $width = null,
        ?int $height = null,
        ?string $aspectRatio = null,
        string|int|null $quality = null,
        ?int $maxDPR = null,
        ?array $crop = null,
        ?array $load = null,
        ?array $thumb = null,
        bool $original = false,
        ?int $rotate = null,
        ?string $background = null,
        ?string $format = null
    ): PicturiumImage {
        return PicturiumImage::create(
            $src,
            $minWidth,
            $width,
            $height,
            $aspectRatio,
            $quality,
            $maxDPR,
            $crop,
            $load,
            $thumb,
            $original,
            $rotate,
            $background,
            $format
        );
    }
}

if (!function_exists("image")) {
    function image(
        ?string $src = null,
        int $minWidth = 0,
        ?int $width = null,
        ?int $height = null,
        ?string $aspectRatio = null,
        string|int|null $quality = null,
        ?int $maxDPR = null,
        ?array $crop = null,
        ?array $load = null,
        ?array $thumb = null,
        bool $original = false,
        ?int $rotate = null,
        ?string $background = null,
        ?string $format = null
    ): PicturiumImage {
        return PicturiumImage::create(
            $src,
            $minWidth,
            $width,
            $height,
            $aspectRatio,
            $quality,
            $maxDPR,
            $crop,
            $load,
            $thumb,
            $original,
            $rotate,
            $background,
            $format
        );
    }
}
