<?php

namespace Ath\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Ath\MainBundle\Entity\UserFollow;
use Ath\MainBundle\Form\Type\UserSettingFormType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
                        return array('id' => $val->getId(), 'value' => $val->__toString(), 'img' => '<img src='.$image.'>','slug' => $val->getSlug(), 'ville' => $ville);
                    },
                    $users
                )
            );

        }

        return new JsonResponse("Ko");

    }
    /**
     * followAction permet de suivre ou de ne plus suivre un user 
     * 
     * @param  Request $request
     * @param  string  $slug   
     * @param  boolean $suivre
     * @return [type]          
     */
    public function followAction(Request $request, $slug,$suivre)
    { 
        $user = $this->getUser();
        $trad = $this->get('translator');
        $em = $this->getDoctrine()->getManager();

        $userToFollow = $em->getRepository('AthUserBundle:User')->findOneBySlug($slug);

        if ($suivre == "1") {
            $userFollow = $em->getRepository('AthMainBundle:UserFollow')->findOneBy(array('userEmetteur' => $user, 'userDestinataire' => $userToFollow));
            
            if (empty($userFollow)) {
                $userFollow = new UserFollow();
                $userFollow->setUserEmetteur($user);
                $userFollow->setUserDestinataire($userToFollow);
                $em->persist($userFollow);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', $trad->trans("flash.new_contact", array('%user%' => $userToFollow), 'home'));
            }
        }
        else {
            $userFollow = $em->getRepository('AthMainBundle:UserFollow')->findOneBy(array('userEmetteur' => $user, 'userDestinataire' => $userToFollow));

            $em->remove($userFollow);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $trad->trans("flash.remove_contact", array('%user%' => $userToFollow), 'home'));
        }
        
        $referer = $request->headers->get('referer');

        if($referer != null)
            return $this->redirect($referer);
        else
            return $this->redirect($this->generateUrl('ath_main_homepage'));
    }


    public function userSettingsAction()
    {
        $user = $this->getUser();
        $trad = $this->get('translator');

        $form = $this->createForm(new UserSettingFormType(), $user->getUserSetting());

        $formHandler = $this->container->get('ath.form.handler.user_setting');
        $formHandler->process($form);

        return $this->render('@ath_user_path/user_settings.html.twig',array(
            'form' => $form->createView()
            ));
    }

    /**
     * followersAction: liste tous les followers d'un utilisateur
     * 
     * @param  Request $request
     * @return [type]          
     */
    public function followersAction(Request $request, $slug)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userToShow = $em->getRepository('AthUserBundle:User')->findOneBySlug($slug);
        
        if(!$userToShow)
            throw new NotFoundHttpException("Page introuvable");

        $followers =  $em->getRepository('AthUserBundle:User')->getTenFollowers($userToShow);
        $amiFollows = $em->getRepository('AthUserBundle:User')->getAmiFollows($user);

        return $this->render('@ath_user_path/followers.html.twig', array(
            'followers' => $followers,
            'amiFollows' => $amiFollows,
            'userToShow' => $userToShow,
            'user' => $user
        ));
    }

    /**
     * followersAjaxAction: scroll infini des folowers d'un utilisateur
     * 
     * @param  Request $request
     * @return [type]          
     */
    public function followersAjaxAction(Request $request, $slug)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userToShow = $em->getRepository('AthUserBundle:User')->findOneBySlug($slug);
        
        $load = $request->get('load');
        $firstResult = (10 * $load) +1;

        if(!$userToShow)
            throw new NotFoundHttpException("Page introuvable");

        $followers =  $em->getRepository('AthUserBundle:User')->getTenFollowers($userToShow, $firstResult);
        
        $amiFollows = $em->getRepository('AthUserBundle:User')->getAmiFollows($user);

        return $this->render('@ath_user_path/ten_followers.html.twig', array(
            'followers' => $followers,
            'amiFollows' => $amiFollows,
            'userToShow' => $userToShow,
            'user' => $user
        ));
    }

}
