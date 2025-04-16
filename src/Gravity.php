<?php

namespace Picturium;

class Gravity
{
    public const CENTER = "center";
    public const TOP = "top";
    public const TOP_LEFT = "top-left";
    public const TOP_RIGHT = "top-right";
    public const BOTTOM = "bottom";
    public const BOTTOM_LEFT = "bottom-left";
    public const BOTTOM_RIGHT = "bottom-right";
    public const LEFT = "left";
    public const RIGHT = "right";

    public const ALLOWED_VALUES = [
        self::CENTER,
        self::TOP,
        self::TOP_LEFT,
        self::TOP_RIGHT,
        self::BOTTOM,
        self::BOTTOM_LEFT,
        self::BOTTOM_RIGHT,
        self::LEFT,
        self::RIGHT,
    ];

    public static function validate(string $gravity): bool
    {
        return in_array($gravity, self::ALLOWED_VALUES, true);
    }
}
