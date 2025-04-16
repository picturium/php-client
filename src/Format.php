<?php

namespace Picturium;

class Format
{
    public const AUTO = "auto";
    public const JPG = "jpg";
    public const WEBP = "webp";
    public const AVIF = "avif";
    public const PNG = "png";
    public const PDF = "pdf";

    public const ALLOWED_VALUES = [self::AUTO, self::JPG, self::WEBP, self::AVIF, self::PNG, self::PDF];

    public static function validate(string $color): bool
    {
        return in_array($color, self::ALLOWED_VALUES, true);
    }
}
