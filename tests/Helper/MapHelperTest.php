<?php
/**
 * Created by PhpStorm.
 * User: croknoks
 * Date: 03/05/18
 * Time: 15:45
 */

namespace App\Croknoks\IdenticonBundle\tests\Helper;

use App\Croknoks\IdenticonBundle\Entity\Color;
use App\Croknoks\IdenticonBundle\Helper\ColorHelper;
use App\Croknoks\IdenticonBundle\Helper\MapHelper;
use PHPUnit\Framework\TestCase;

class MapHelperTest extends TestCase
{
    public function testColorNegative()
    {
        $map = MapHelper::mapFactory(md5('azerty'));

        $this->assertEquals(3, $map->getCenter()->getRotation());
        $this->assertEquals(171, $map->getCenter()->getShape());
        $this->assertEquals(new Color(254, 204, 227), $map->getCenter()->getColor());
        $this->assertEquals('center', $map->getCenter()->getName());

        $this->assertEquals(1, $map->getSide()->getRotation());
        $this->assertEquals(101, $map->getSide()->getShape());
        $this->assertEquals(new Color(192, 172, 191), $map->getSide()->getColor());
        $this->assertEquals('side', $map->getSide()->getName());

        $this->assertEquals(0, $map->getCorner()->getRotation());
        $this->assertEquals(104, $map->getCorner()->getShape());
        $this->assertEquals(new Color(251, 176, 183), $map->getCorner()->getColor());
        $this->assertEquals('corner', $map->getCorner()->getName());
    }

    public function testGetShape()
    {
        MapHelper::setShapes(
            [
                'border' => [
                    ['points' => '0'],
                    ['points' => '1'],
                    ['points' => '2'],
                    ['points' => '3'],
                    ['points' => '4'],
                    ['points' => '5'],
                    ['points' => '6'],
                    ['points' => '7'],
                ],
            ]
        );

        $this->assertEquals('1', MapHelper::getShape(1, 'corner'));
        $this->assertEquals('1', MapHelper::getShape(15, 'corner'));

    }
}