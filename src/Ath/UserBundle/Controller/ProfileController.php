<?php

namespace Ath\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Ath\UserBundle\Form\EditProfileAssocType;
use Ath\UserBundle\Form\EditProfileType;
use Ath\MainBundle\Form\Type\DemandeCelebriteFormType;
use Ath\MainBundle\Entity\DemandeCelebrite;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ath\MainBundle\Form\Type\PostFormType;

class ProfileController extends BaseController
{
     /**
     * Show the user
     */
   /* public function showAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userToShow = $em->getRepository('AthUserBundle:User')->findOneBySlug($slug);
        
        // if (!is_object($user) || !$user instanceof UserInterface) {
        //     throw new AccessDeniedException('This user does not have access to this section.');
        // }

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'userToShow' => $userToShow
        ));

    }*/

    public function showProfileAction(Request $request, $slug)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userToShow = $em->getRepository('AthUserBundle:User')->findOneBySlug($slug);
        
        if(!$userToShow)
            throw new NotFoundHttpException("Page introuvable");

        // if (!is_object($user) || !$user instanceof UserInterface) {
        //     throw new AccessDeniedException('This user does not have access to this section.');
        // }
        $followers =  $em->getRepository('AthUserBundle:User')->getLastFollowers($userToShow);

        $countFollowers = $em->getRepository('AthUserBundle:User')->countFollowers($userToShow);

        $amiFollows = $em->getRepository('AthUserBundle:User')->getAmiFollows($user);
        
        if ($userToShow->hasRole('ROLE_CELEBRITE')) {
            $produits = $em->getRepository('AthMainBundle:Produit')->getMyProducts($userToShow);
        }
        else // on récupère les products de son comparateur
        {
            $comparateurProduits = $userToShow->getUserComparateurProduits();
            $produits = array();
            foreach ($comparateurProduits as $oneProduit) {
                $produits[] = $oneProduit;
            }
        }

        $noProduct = false;
        if(!$produits){
            // on récupère les 20 derniers produits
            $produits = $em->getRepository('AthMainBundle:Produit')->getLastProductsLimit();
            $noProduct = true;
        }

        // 10 derniers posts
        $posts = $em->getRepository('AthMainBundle:Post')->getMyLimitfeed($userToShow);

        $form = $this->createForm(new PostFormType());

		$tableau = array();
		
		
		if($flux = simplexml_load_file('http://www.lequipe.fr/rss/actu_rss.xml'))
		{
		   $donnee = $flux->channel;
		
		   //Lecture des données
		
		   foreach($donnee->item as $valeur)
		   {
			  //Affichages des données
			if ($valeur->enclosure['url'] == "") continue;
		   $tableau[] = ["link" => $valeur->link,
		   				"image" => $valeur->enclosure['url'],
						"title" => substr($valeur->title, 0, 45)."...",
						"fulltitle" => $valeur->title,
						"description" => $valeur->description,
						"date" => date("d/m/Y", strtotime($valeur->pubDate))];
		   }
		}else echo 'Erreur de lecture du flux RSS';


        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'userToShow' => $userToShow,
            'followers' => $followers,
            'amiFollows' => $amiFollows,
            'countFollowers' => $countFollowers,
            'posts' => $posts,
            'form' => $form->createView(),
            'produits' => $produits,
            'noProduct' => $noProduct,
			'lequipe' => $tableau
        ));
    }
    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        if($user->getStatutJuridiqueId() == 3)
            $form = $this->createForm(new EditProfileAssocType(), $user);
        else
            $form = $this->createForm(new EditProfileType(), $user);

        $formHandler = $this->container->get('ath.user.form.handler.edit_profile');
        
        // Enregistrement des modifications + setflash
        $formHandler->process($form);

        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView(),
            'canDemandeCelebrite' => $user->canDemandeCelebrite()
        ));
    }

    public function removePhotoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $trad = $this->container->get('translator');

        $user = $this->getUser();

        $user->removePhoto();

        $user->setPhotoId(null);
        $user->setPhotoExtension(null);
        $user->setPhotoOriginalName(null);

        $em->persist($user);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', $trad->trans("profile.flash.photoSupprimer", array(), 'home'));

        return $this->redirect($this->generateUrl('fos_user_profile_edit'));
    }

    public function demandeCelebriteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if (!$user->canDemandeCelebrite()) {
            return $this->redirect($this->generateUrl('fos_user_profile_edit'));
        }
        $demandeCelebrite = new DemandeCelebrite();
        $demandeCelebrite->setCreatedBy($user);

        $form = $this->createForm(new DemandeCelebriteFormType(), $demandeCelebrite);

        $formHandler = $this->container->get('ath.form.handler.demande_celebrite');
        if($formHandler->process($form))
        {
            $sendMail = $this->container->get('ath_main.services.send_mail');
            $groups = $em->getRepository('AthMainBundle:GroupApplication')->findAll();
            $aUser = array();
            foreach ($groups as $group) {
                foreach ($group->getUsers() as $utilisateur) {
                    if ($utilisateur != $user && !array_key_exists($utilisateur->getId(), $aUser)) {
                        if ($utilisateur->hasRole('ROLE_ADMIN_DEMANDE_CELEBRITE')) {
                            $aUser[$utilisateur->getId()] = $utilisateur;
                        }
                    }
                }
            }
            foreach ($aUser as $oneUser) {
                $sendMail->demandeCelebrite($user,$oneUser, $form->getData()->getContenu());
            }
            // $sendMail->demandeCelebrite($user, $form->getData()->getContenu());
            return $this->redirect($this->generateUrl('fos_user_profile_edit'));
        }

        return $this->render('@ath_user_path/demande_celebrite.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function myPostsAjaxAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            
            $load = $request->get('load');
            $id = $request->get('id');

            $firstResult = (10 * $load) +1;

            $userToShow = $em->getRepository('AthUserBundle:User')->find($id);

            // 10 posts suivant
            $posts = $em->getRepository('AthMainBundle:Post')->getMyTenPosts($userToShow,$firstResult);

            return $this->render('@ath_main_path/Post/ten_posts.html.twig', array(
                'posts' => $posts,
            ));
        }
       
        return new JsonResponse("Ko");
    }
}