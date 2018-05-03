<?php
/**
 * Created by PhpStorm.
 * User: croknoks
 * Date: 03/05/18
 * Time: 11:56
 */

namespace App\Croknoks\IdenticonBundle\Entity;


class Map
{
    protected $center;
    protected $side;
    protected $corner;

    public function __construct()
    {
        $this->center = new Sprite();
        $this->side = new Sprite();
        $this->corner = new Sprite();
    }

    public function getCenter(): Sprite
    {
        return $this->center;
    }

    public function getSide(): Sprite
    {
        return $this->side;
    }

    public function getCorner(): Sprite
    {
        return $this->corner;
    }

    /**
     * @param $type
     *
     * @return Sprite
     */
    public function get($type)
    {
        switch ($type) {
            case 'center' :
                $value = $this->getCenter();
                break;
            case 'side' :
                $value = $this->getSide();
                break;
            case 'corner' :
                $value = $this->getCorner();
                break;
            default:
                $value = null;
        }

        return $value;
    }

}
