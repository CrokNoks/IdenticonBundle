<?php
/**
 * Created by PhpStorm.
 * User: croknoks
 * Date: 03/05/18
 * Time: 12:23
 */

namespace App\Croknoks\IdenticonBundle\Helper;


use App\Croknoks\IdenticonBundle\Entity\Sprite;

class SpriteHelper
{

    public static function createSprite(Sprite $spriteData, $bg_color, $width, $monochrome = false)
    {
        if (!$monochrome) {
            $color = $spriteData->getColor();
        } else {
            $color = $monochrome;
        }
        $rotation = $spriteData->getRotation();

        $sprite = imagecreatetruecolor($width, $width);

        $fg = ColorHelper::allocate($sprite, $color);
        $bg = ColorHelper::allocate($sprite, $bg_color);
        imagefilledrectangle($sprite, 0, 0, $width, $width, $bg);

        $shape = self::getShape($spriteData->getShape(), $spriteData->getName());
        /* apply ratios */
        for ($i = 0; $i < count($shape); $i++) {
            $shape[$i] = $shape[$i] * $width;
        }
        imagefilledpolygon($sprite, $shape, count($shape) / 2, $fg);
        /* rotate the sprite */
        for ($i = 0; $i < $rotation; $i++) {
            $sprite = imagerotate($sprite, 90, $bg);
        }

        $spriteData->setImage($sprite);
    }

    /**
     * @param $num
     * @param $type
     *
     * @return mixed
     */
    protected static function getShape($num, $type)
    {
        $shapes = MapHelper::getShapes();

        if ($type == 'corner' || $type == 'side') {
            $type = 'border';
        }

        if (count([$type]) < $num) {
            $index = $num % (count($shapes[$type]) - 1);
        } else {
            $index = $num;
        }

        return $shapes[$type][$index]['points'];
    }

}