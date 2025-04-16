<?php

namespace Picturium;

class Quality
{
    public const AUTO = "auto";

    public const ALLOWED_VALUES = [self::AUTO];

    public static function validate(string $quality): bool
    {
        return in_array($quality, self::ALLOWED_VALUES, true);
    }
}
