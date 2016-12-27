<?php

namespace Ath\MainBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Ath\MainBundle\Entity\DemandeCelebrite;

class DemandeCelebriteAdminController extends Controller
{
    /**
     * [reponseDemandeCelebriteAction description]
     * @param  Request $request [description]
     * 
     * @return Response redirect listDemandeCelebrite
     */
    public function reponseDemandeCelebriteAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();

    	$object = $this->admin->getSubject();
    	$statut = $request->get('statut');
    	$user = $this->getUser();

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN_REPONSE_DEMANDE_CELEBRITE')) {
            throw $this->createAccessDeniedException();
        }

    	if($statut == 2)
    	{
    		$object->setStatut(2);
    		$object->setUpdatedBy($user);
    		$object->setDateReponse(new \DateTime());
    		$em->flush();
    		$demandeur = $object->getCreatedBy();
    		$demandeur->addRole("ROLE_CELEBRITE");
    		$em->flush();

    		$sendMail = $this->container->get('ath_main.services.send_mail');
    		$sendMail->validationDemandeCelebrite($object);
           	$this->addFlash('sonata_flash_success', 'La demande de célébrité n°'.$object->getId(). ' a bien été accepté');

    	}
    	else // on refuse la demande
    	{
    		$object->setStatut(3);
    		$object->setUpdatedBy($user);
    		$object->setDateReponse(new \DateTime());
    		$em->flush();
    		$sendMail = $this->container->get('ath_main.services.send_mail');
    		$sendMail->refusDemandeCelebrite($object);
           	$this->addFlash('sonata_flash_success', 'La demande de célébrité n°'.$object->getId(). ' a bien été refusé');
    	}

    	return $this->redirect($this->generateUrl('admin_ath_main_demandecelebrite_list'));
    }
}
