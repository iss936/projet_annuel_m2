<?php

namespace Ath\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Ath\MainBundle\Entity\UserFollow;
use Ath\MainBundle\Form\Type\UserSettingFormType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ath\MainBundle\Form\Type\PostFormType;
use Ath\MainBundle\Entity\Post;
use Ath\MainBundle\Entity\Comment;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
    	$user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('AthMainBundle:EventAdmin')->getNotFinishedLimitEvents($user);
        
        $countEvents = $em->getRepository('AthMainBundle:EventAdmin')->getCountNotFinishedEvents($user);

        $amis = $em->getRepository('AthUserBundle:User')->getAmiFollows($user);
        // 10 derniers posts
        $posts = $em->getRepository('AthMainBundle:Post')->getLimitfeed($user,$amis);

        $form = $this->createForm(new PostFormType());

        return $this->render('@ath_main_path/index.html.twig', array(
            'events' => $events,
            'countEvents' => $countEvents,
            'posts' => $posts,
            'amis' => $amis,
            'form' => $form->createView()

        ));
    }

    public function addPostAction(Request $request)
    {
        $user = $this->getUser();
        $post = new Post();
        $post->setCreatedBy($user);

        $form = $this->createForm(new PostFormType(), $post);
        $formHandler = $this->container->get('ath.form.post_handler');

        $formHandler->process($form);
        $referer = $request->headers->get('referer');

        if($referer != null)
            return $this->redirect($referer);
        else
            return $this->redirect($this->generateUrl('ath_main_homepage'));
    }

    public function postsAjaxAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            
            $load = $request->get('load');
            $firstResult = (10 * $load) +1;

            $amis = $em->getRepository('AthUserBundle:User')->getAmiFollows($user);

            // 10 posts suivant
            $posts = $em->getRepository('AthMainBundle:Post')->getTenPosts($user,$amis,$firstResult);
            /*$tabComments = array();
            foreach ($posts as $onePost) {
                if ($onePost->getParent() != null) {
                    $onePost = $onePost->getParent();
                }
                $tabComments[$onePost->getId()] = $onePost->getTenLastComments();
            }*/

            return $this->render('@ath_main_path/Post/ten_posts.html.twig', array(
                // 'amis' => $amis,
                'posts' => $posts,
                // 'tabComments' => $tabComments

            ));

        }
       
        return new JsonResponse("Ko");
    }
    public function searchUserAjaxAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
        	
            $users = $em->getRepository('AthUserBundle:User')->getUserActivesAutocomplete($request->query->get('string'));
            if (!$users) {
                return new JsonResponse("ko");
            }
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

    /**
     * followersAction: liste tous les évènements à venir en fonction des usersInteretsSports
     * 
     * @param  Request $request
     * @return [type]          
     */
    public function eventSportifsAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $events =  $em->getRepository('AthMainBundle:EventAdmin')->getTenNotFinishedLimitEvents($user);

        return $this->render('@ath_main_path/Event/event_sportifs.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * eventSportifsAjaxAction: scroll infini des evenements sportifs
     * 
     * @param  Request $request
     * @return [type]          
     */
    public function eventSportifsAjaxAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        
        $load = $request->get('load');
        $firstResult = (10 * $load) +1;

        $events =  $em->getRepository('AthMainBundle:EventAdmin')->getTenNotFinishedLimitEvents($user, $firstResult);
        
        return $this->render('@ath_main_path/Event/ten_event_sportifs.html.twig', array(
            'events' => $events,
        ));
    }

    public function addCommentAjaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $message = $request->get('message');
            $idPost = $request->get('idPost');
            $user = $this->getUser();

            $post = $em->getRepository('AthMainBundle:Post')->find($idPost);
            
            $comment = new Comment();
            $comment->setCreatedBy($user);
            $comment->setPost($post);
            $comment->setMessage($message);
            $em->persist($comment);
            $em->flush();

            return $this->render('@ath_main_path/Comment/ten_last_comments.html.twig', array(
                'post' => $post,
            ));
        }
    }

    public function moreCommentsAjaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $load = $request->get('load');
            $idPost = $request->get('idPost');
            $user = $this->getUser();

            $post = $em->getRepository('AthMainBundle:Post')->find($idPost);

            $nbComments = count($post->getComments());
            $nbToPrint = 10*$load;
            $first = $nbComments - $nbToPrint;
            if ($first <=0) {
                $first = 0;
            }

            $comments = $em->getRepository('AthMainBundle:Comment')->moreComments($post,$first);
        
            return $this->render('@ath_main_path/Comment/more_comments.html.twig', array(
                'comments' => $comments,
            ));
        }
    }

    public function sharePostAction(Request $request,$idPost)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $post = $em->getRepository('AthMainBundle:Post')->find($idPost);
        if(!$post)
            throw new NotFoundHttpException("Page introuvable");

        $partage = new Post();
        $partage->setParent($post);
        $partage->setCreatedBy($user);
        $partage->setContenu($post->getContenu());
        $em->persist($partage);
        $em->flush();

        $referer = $request->headers->get('referer');

        if($referer != null)
            return $this->redirect($referer);
        else
            return $this->redirect($this->generateUrl('ath_main_homepage'));
    }

    public function removePostAjaxAction(Request $request)
    {
        $ok = false;
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $idPost = $request->get('idPost');

            $post = $em->getRepository('AthMainBundle:Post')->find($idPost);
            $em->remove($post);
            $em->flush();
            
            $ok = true;
        }
        
        return new JsonResponse($ok);
    }

    public function likePostAjaxAction(Request $request)
    {
        $ok = false;
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            $idPost = $request->get('idPost');
            $realId = $request->get('realId');
            $remove = $request->get('remove');

            $onePost = $em->getRepository('AthMainBundle:Post')->find($idPost);
            // add or remove a like
            $onePost->clickLike($user,$remove);
            if ($remove == 'false') {
                $em->persist($onePost);
            }
            $em->flush();
            /*var_dump($remove,count($onePost->getUserLikes()));
            die();*/

            return $this->render('@ath_main_path/Post/like_post.html.twig', array(
                'onePost' => $onePost,
                'realId' => $realId
            ));
        }
        
        return new JsonResponse($ok);
    }
}
