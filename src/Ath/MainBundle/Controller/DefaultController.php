<?php

namespace Ath\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

	/**
     * @Route("/", name="ath_main_homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@ath_main_path/index.html.twig');
    }
}
