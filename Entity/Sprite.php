<?php
/**
 * Created by PhpStorm.
 * User: croknoks
 * Date: 03/05/18
 * Time: 11:58
 */

namespace App\Croknoks\IdenticonBundle\Entity;


class Sprite
{
    private $rotation;
    private $shape;
    private $color;

    private $image;

    private $name;

    public function __construct()
    {
        $this->rotation = 0;
        $this->shape = 0;
        $this->color = null;
    }

    /**
     * @return mixed
     */
    public function getRotation()
    {
        return $this->rotation;
    }

    /**
     * @param mixed $rotation
     */
    public function setRotation($rotation): Sprite
    {
        $this->rotation = $rotation;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @param mixed $shape
     */
    public function setShape($shape): Sprite
    {
        $this->shape = $shape;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getColor(): ?Color
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor(Color $color): Sprite
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): Sprite
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): Sprite
    {
        $this->name = $name;

        return $this;
    }
}