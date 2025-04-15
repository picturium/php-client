<?php

namespace Picturium;

class Color
{
    public const TRANSPARENT = "transparent";
    public const BLACK = "black";
    public const SILVER = "silver";
    public const GRAY = "gray";
    public const WHITE = "white";
    public const MAROON = "maroon";
    public const RED = "red";
    public const PURPLE = "purple";
    public const FUCHSIA = "fuchsia";
    public const GREEN = "green";
    public const LIME = "lime";
    public const OLIVE = "olive";
    public const YELLOW = "yellow";
    public const NAVY = "navy";
    public const BLUE = "blue";
    public const TEAL = "teal";
    public const AQUA = "aqua";

    public const ALLOWED_VALUES = [
        self::TRANSPARENT,
        self::BLACK,
        self::SILVER,
        self::GRAY,
        self::WHITE,
        self::MAROON,
        self::RED,
        self::PURPLE,
        self::FUCHSIA,
        self::GREEN,
        self::LIME,
        self::OLIVE,
        self::YELLOW,
        self::NAVY,
        self::BLUE,
        self::TEAL,
        self::AQUA,
    ];

    public static function validate(string $color): bool
    {
        if (in_array($color, self::ALLOWED_VALUES, true)) {
            return true;
        }

        return preg_match('/^hex:([0-9a-f]{6,8})$/', $color) ||
            preg_match('/^rgb:[0-9]{1,3},[0-9]{1,3},[0-9]{1,3}(,[0-9]{1,3}(%)?)?$/', $color) ||
            preg_match('/^hsl:[0-9]{1,3},[0-9]{1,3}(%)?,[0-9]{1,3}(%)?(,[0-9]{1,3}(%)?)?$/', $color);
    }
}
