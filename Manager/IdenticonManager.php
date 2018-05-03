<?php

namespace App\Croknoks\IdenticonBundle\Manager;

use App\Croknoks\IdenticonBundle\Entity\Map;
use App\Croknoks\IdenticonBundle\Helper\ColorHelper;
use App\Croknoks\IdenticonBundle\Helper\MapHelper;
use App\Croknoks\IdenticonBundle\Helper\SpriteHelper;
use Symfony\Component\DependencyInjection\Container;

class IdenticonManager
{
    private $container;

    /**
     * @var Map
     */
    private $map;

    private $parameters;

    private $options;

    /**
     * IdenticonManager constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->parameters = $this->container->getParameter('cn_identicon');
        MapHelper::setShapes($this->parameters['shapes']);

        $this->options = $this->getDefaultOptions();
    }

    /**
     * @param null $options
     */
    public function setOptions($options = null)
    {
        $new_options = [];
        if (is_array($options)) {
            foreach ($options as $option) {
                $opt = explode('-', $option);
                $new_options[$opt[0]] = $opt[1];
            }
        }

        $this->options = array_merge($this->getDefaultOptions(), $new_options);

        ColorHelper::$negative = boolval($this->options['negative']);

        $this->options['background'] = ColorHelper::negative($this->options['background']);
    }

    /**
     * @return array
     */
    public function getDefaultOptions()
    {
        return [
            'random' => false,
            'multiplier' => 3,
            'repeat' => 5,
            'monochrome' => false,
            'negative' => false,
            'spriteWidth' => 256,
            'background' => ColorHelper::ColorStaticFactory(255, 255, 255),
        ];
    }

    /**
     * @param $typeName
     */
    protected function getSprite($typeName)
    {
        $spriteType = $this->map->get($typeName);

        $monochrome = false;
        if ($this->options['monochrome']) {
            $monochrome = $this->map->getCorner()->getColor();
        }

        SpriteHelper::createSprite($spriteType, $this->options['background'], $this->options['spriteWidth'], $monochrome );
    }

    /**
     * @param $identicon
     * @param $bg
     *
     * @return mixed
     */
    private function getCubedSprite($identicon, $bg)
    {
        $spriteZ = $this->options['spriteWidth'];
        $this->getSprite('corner');
        $this->getSprite('side');
        $this->getSprite('center');

        $corner = $this->map->get('corner')->getImage();
        for($i=0; $i<4; $i++) {
            imagecopy($identicon, $corner, 0, 0, 0, 0, $spriteZ, $spriteZ);
            $identicon = imagerotate($identicon, 90, $bg);
        }
        $side = $this->map->get('side')->getImage();
        for($i=0; $i<4; $i++) {
            imagecopy($identicon, $side, $spriteZ, 0, 0, 0, $spriteZ, $spriteZ);
            $identicon = imagerotate($identicon, 90, $bg);
        }

        $center = $this->map->get('center')->getImage();
        imagecopy($identicon, $center, $spriteZ, $spriteZ, 0, 0, $spriteZ, $spriteZ);

        return $identicon;

    }

    /**
     * @param     $hash
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    public function getIdenticon($hash, $width = 48, $height = 48)
    {
        $this->map = MapHelper::mapFactory($hash);

        /* size of each sprite */

        /* start with blank 3x3 identicon */
        $identicon = imagecreatetruecolor(
            $this->options['spriteWidth'] * $this->options['multiplier'],
            $this->options['spriteWidth'] * $this->options['multiplier']
        );

        /* assign white as background */
        $bg_identicon = ColorHelper::allocate($identicon, ColorHelper::ColorStaticFactory(255, 255, 255));
        imagefilledrectangle(
            $identicon,
            0,
            0,
            $this->options['spriteWidth'],
            $this->options['spriteWidth'],
            $bg_identicon
        );

        /* generate corner sprites */
        $identicon = $this->getCubedSprite($identicon, $bg_identicon);

        /* make white transparent */
        imagecolortransparent($identicon, $bg_identicon);

        /* create blank image according to specified dimensions */
        $resized = imagecreatetruecolor($width, $height);

        /* assign white as background */
        $bg_resized = ColorHelper::allocate($identicon, ColorHelper::ColorStaticFactory(255, 255, 255));
        imagefilledrectangle($resized, 0, 0, $width, $height, $bg_resized);

        /* resize identicon according to specification */
        $resized = $this->mozaic($resized, $identicon, $width, $height);

        /* make white transparent */
        imagecolortransparent($resized, $bg_resized);

        ob_start();
        imagepng($resized);
        $image_data = ob_get_contents();
        ob_end_clean();

        /* and finally, send to standard output */

        return $image_data;
    }

    /**
     * @param $imgresized
     * @param $imgidenticon
     * @param $width
     * @param $height
     *
     * @return mixed
     */
    private function mozaic($imgresized, $imgidenticon, $width, $height)
    {
        $min_width = ceil($width / $this->options['repeat']) * $this->options['repeat'];
        $min_height = ceil($height / $this->options['repeat']) * $this->options['repeat'];
        $imgLine = imagecreatetruecolor($min_width, $min_height/$this->options['repeat']);
        $finalImage = imagecreatetruecolor($min_width, $min_height);
        // on créé la première ligne de la mozaique
        for ($i = 0; $i < $this->options['repeat']; $i++) {
            imagecopyresampled(
                $imgLine, // ressources destination
                $imgidenticon, // ressources source
                $min_width / $this->options['repeat'] * $i, // origine x destination
                0, // origine y destination
                0, // origine x de la source
                0, // origine y de la source
                $min_width / $this->options['repeat'], // destination largeur
                $min_height / $this->options['repeat'], // destination hauteur
                imagesx($imgidenticon), // source largeur
                imagesy($imgidenticon)
            );
        }
        // on duplique la prmeière ligne autant de fois qu'on veux pour remplir l'image
        for ($j = 0; $j < $this->options['repeat']; $j++) {
            imagecopyresampled(
                $finalImage, // ressources destination
                $imgLine, // ressources source
                0, // origine x destination
                $min_height / $this->options['repeat'] * $j, // origine y destination
                0, // origine x de la source
                0, // origine y de la source
                $min_width, // destination largeur
                $min_height / $this->options['repeat'], // destination hauteur
                imagesx($imgLine),
                imagesy($imgLine)
            );
        }

        imagecopyresampled($imgresized, $finalImage, 0, 0, 0, 0, $width, $height, $min_width, $min_height);

        return $imgresized;
    }
}
