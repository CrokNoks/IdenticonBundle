<?php

namespace App\Croknoks\IdenticonBundle\Helper;

use App\Croknoks\IdenticonBundle\Entity\Color;

class ColorHelper
{
    /**
     * @var boolean
     */
    public static $negative;

    /**
     * @param Color $color
     *
     * @return Color
     */
    public static function negative(Color $color): Color
    {
        if (!self::$negative) {
            return $color;
        }

        return new Color(255 - $color->getRed(), 255 - $color->getGreen(), 255 - $color->getBlue());
    }

    /**
     * @param Color $color
     *
     * @return Color
     */
    public static function limitColor(Color $color): Color
    {
        $invertedColor = new Color(
            $color->getRed() % 100 + 155,
            $color->getGreen() % 100 + 155,
            $color->getBlue() % 100 + 155
        );

        return self::negative($invertedColor);
    }

    /**
     * @param $hash
     * @param $pas
     * @param $variant
     *
     * @return Color
     */
    public static function ColorFactory($hash, $pas, $variant): Color
    {
        $color = new Color(
            hexdec(substr($hash, $pas * ($variant), $pas)),
            hexdec(substr($hash, $pas * ($variant + 1), $pas)),
            hexdec(substr($hash, $pas * ($variant + 2), $pas))
        );

        return self::limitColor($color);
    }

    /**
     * @param $red
     * @param $green
     * @param $blue
     *
     * @return Color
     */
    public static function ColorStaticFactory($red, $green, $blue): Color
    {
        $color = new Color($red, $green, $blue);
        return $color;
    }

    /**
     * @param       $identicon
     * @param Color $color
     *
     * @return int
     */
    public static function allocate($identicon, Color $color)
    {
        return imagecolorallocate($identicon, $color->getRed(), $color->getGreen(), $color->getBlue());
    }
}
