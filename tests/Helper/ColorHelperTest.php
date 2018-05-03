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
use PHPUnit\Framework\TestCase;

class ColorHelperTest extends TestCase
{
    public function testColorNegative()
    {
        $color = new Color(255,255,255);
        $newColor = ColorHelper::negative($color);

        $this->assertEquals($color,$newColor);

        ColorHelper::$negative=true;
        $newColor = ColorHelper::negative($color);

        $this->assertEquals(new Color(0,0,0),$newColor);
    }

    public function testColorFactory() {
        ColorHelper::$negative=false;
        $color = ColorHelper::ColorFactory(md5('azerty'), 1,1);

        $this->assertEquals(new Color(166, 159, 170), $color);
    }

    public function testLimitFactory() {
        ColorHelper::$negative=false;
        $this->assertEquals(new Color(155, 155, 155), ColorHelper::limitColor(new Color(0,0,0)));
        $this->assertEquals(new Color(155, 155, 155), ColorHelper::limitColor(new Color(100,100,100)));
        $this->assertEquals(new Color(210, 210, 210), ColorHelper::limitColor(new Color(255,255,255)));
        $this->assertEquals(new Color(210, 160, 205), ColorHelper::limitColor(new Color(2055,2505,2550)));
    }

}