<?php

namespace Ath\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // die("ok");
    }

    public function choisirLangueAction(Request $request, $langue = null)
    {
        if ($langue != null) {
            // On enregistre la langue en session
            $this->get('session')->set('_locale', $langue);
            $this->getRequest()->setLocale($this->get('session')->get('_locale'));
            $this->get('translator')->setLocale($langue);
        }

        // on tente de rediriger vers la page d'origine
        $url = $this->container->get('request')->headers->get('referer');

        if (empty($url)) {
            $url = $this->container->get('router')->generate('ath_main_homepage');
        }

        return $this->redirect($url);
    }
}
