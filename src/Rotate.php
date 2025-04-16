<?php

namespace Picturium;

class Rotate
{
    public const NONE = 0;
    public const LEFT = 90;
    public const UPSIDE_DOWN = 180;
    public const RIGHT = 270;

    public const ALLOWED_VALUES = [self::NONE, self::LEFT, self::UPSIDE_DOWN, self::RIGHT];

    public static function validate(string $rotate): bool
    {
        return in_array($rotate, self::ALLOWED_VALUES, true);
    }
}
