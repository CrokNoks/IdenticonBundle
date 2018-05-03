<?php
/**
 * Created by PhpStorm.
 * User: croknoks
 * Date: 03/05/18
 * Time: 11:55
 */

namespace App\Croknoks\IdenticonBundle\Helper;


use App\Croknoks\IdenticonBundle\Entity\Map;

class MapHelper
{

    private static $shapes;

    public static function setShapes($shapes) {
        self::$shapes = $shapes;
    }

    /**
     * @param $hash
     *
     * @return Map
     */
    public static function mapFactory($hash)
    {
        $map = new Map();

        $pas = floor(strlen($hash) / 14);

        $map->getCenter()
            ->setShape(hexdec(substr($hash, $pas * 0, $pas)))
            ->setRotation(hexdec(substr($hash, $pas * 1, $pas)) & 3)
            ->setColor(ColorHelper::ColorFactory($hash, $pas, 2))
            ->setName('center')
        ;
        $map->getSide()
            ->setShape(hexdec(substr($hash, $pas * 5, $pas)))
            ->setRotation(hexdec(substr($hash, $pas * 6, $pas)) & 3)
            ->setColor(ColorHelper::ColorFactory($hash, $pas, 7))
            ->setName('side')
        ;
        $map->getCorner()
            ->setShape(hexdec(substr($hash, $pas * 10, $pas)))
            ->setColor(ColorHelper::ColorFactory($hash, $pas, 11))
            ->setName('corner')
        ;

        return $map;
    }

    /**
     * @param $num
     * @param $type
     *
     * @return mixed
     */
    public static function getShape($num, $type)
    {
        if ($type == 'corner' || $type == 'side') {
            $type = 'border';
        }
        if (count(self::$shapes[$type]) < $num) {
            $index = $num % (count(self::$shapes[$type]) - 1);
        } else {
            $index = $num;
        }

        return self::$shapes[$type][$index]['points'];
    }

    public static function getShapes() {
        return self::$shapes;
    }

}