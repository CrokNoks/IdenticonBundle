<?php
/**
 * Created by PhpStorm.
 * User: croknoks
 * Date: 03/05/18
 * Time: 09:03
 */

namespace App\Croknoks\IdenticonBundle\Entity;


class Color
{
    private $red;
    private $blue;
    private $green;

    public function __construct($red, $green, $blue)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    /**
     * @return mixed
     */
    public function getRed()
    {
        return $this->red;
    }
    /**
     * @param mixed $red
     *
     * @return Color
     */
    public function setRed($red): Color
    {
        $this->red = $red;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getBlue()
    {
        return $this->blue;
    }
    /**
     * @param mixed $blue
     *
     * @return Color
     */
    public function setBlue($blue): Color
    {
        $this->blue = $blue;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getGreen()
    {
        return $this->green;
    }
    /**
     * @param mixed $green
     *
     * @return Color
     */
    public function setGreen($green): Color
    {
        $this->green = $green;

        return $this;
    }
}