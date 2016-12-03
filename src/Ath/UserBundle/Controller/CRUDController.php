<?php

namespace Ath\UserBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ath\UserBundle\Form\Type\ChangePasswordFormType;
use Symfony\Component\HttpFoundation\Request;

class CRUDController extends Controller
{
    public function passwordAction(Request $request)
    {
        $Utilisateur = $this->admin->getSubject();

        if (!$Utilisateur) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $formPassword = $this->createForm(new ChangePasswordFormType());
        if ($request->getMethod() == 'POST') {
            $formPassword->bind($request);
            if ($formPassword->isValid()) {
                $aChangePassword = $request->request->get('change_password');
                $sPassword = $aChangePassword['new']['first'];

                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($Utilisateur);
                $Utilisateur->setPassword($encoder->encodePassword($sPassword, $Utilisateur->getSalt()));

                $em = $this->getDoctrine()->getManager();
                $em->persist($Utilisateur);
                $em->flush();


                $this->get('session')->getFlashBag()->add('success', "Mot de passe modifié est : '".$sPassword."' ");

                return new RedirectResponse($this->admin->generateUrl('list'));

            }
        }

        return $this->render('@ath_admin_path/User/password.html.twig', array(
                                'Utilisateur'  => $Utilisateur,
                                'form'         => $formPassword->createView()
                            ));
    }
}
