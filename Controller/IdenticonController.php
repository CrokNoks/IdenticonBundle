<?php
/**
 * Created by PhpStorm.
 * User: croknoks
 * Date: 30/04/18
 * Time: 17:55
 */

namespace App\Croknoks\IdenticonBundle\Controller;


use App\CrokNoks\IdenticonBundle\Manager\IdenticonManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IdenticonController extends Controller
{

    /**
     * @param string $slug
     * @param int    $width
     * @param int    $height
     * @param null   $options
     *
     * @return Response
     */
    public function show(string $slug, int $width=48, int $height=48, $options = null)
    {
        /** @var IdenticonManager $identiconManager */
        $identiconManager = $this->get('Croknoks.IdenticonManager');

        if (null !== $options) {
            $options = explode(',', $options);
            if(!is_array($options)) {
                $options=[$options];
            }
        }
        $identiconManager->setOptions($options);


        $content = $identiconManager->getIdenticon(md5($slug), $width,$height);

        return new Response(
            $content,
            Response::HTTP_OK,
            ['content-type' => 'image/png']
        );
    }


}