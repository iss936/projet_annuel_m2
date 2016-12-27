<?php

namespace Ath\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
    	$user = $this->getUser();

        return $this->render('@ath_main_path/index.html.twig');
    }

    public function searchUserAjaxAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
        	
            $users = $em->getRepository('AthUserBundle:User')->getUserActivesAutocomplete($request->query->get('string'));

            return new JsonResponse(
                array_map(
                    function ($val) {
        				$trad = $this->get('translator');

                    	$image = $this->get('liip_imagine.cache.manager')->getBrowserPath($val->getWebPath(), 'mini');

                    	$ville = ($val->getVille()) ? $val->getVille() : $trad->trans("villeNonRenseigne", array(), 'home');
                    	// $image = $this->container->get('liip_imagine.filter.manager')->applyFilter($val->getWebPath(), 'small')->getContent();
                        return array('id' => $val->getId(), 'value' => $val->__toString(), 'img' => '<img src='.$image.'>', 'ville' => $ville);
                    },
                    $users
                )
            );

        }

        return new JsonResponse("Ko");

    }
}
