<?php

namespace Picturium;

class AspectRatio
{
    public const AUTO = "auto";
    public const VIDEO = "video";
    public const SQUARE = "square";

    public const ALLOWED_VALUES = [self::AUTO, self::VIDEO, self::SQUARE];

    public static function validate(string|int $aspectRatio): bool
    {
        return in_array($aspectRatio, self::ALLOWED_VALUES, true) ||
            preg_match('/^([0-9]*?)\/([0-9]*?)$/', $aspectRatio);
    }
}
