<?php

namespace Ath\UserBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ath\UserBundle\Form\Type\MyChangePasswordFormType;
use Symfony\Component\HttpFoundation\Request;

class CRUDController extends Controller
{
    public function passwordAction(Request $request)
    {
        $user = $this->admin->getSubject();

        if (!$user) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN_USER_PASSWORD')) {
            throw $this->createAccessDeniedException();
        }
        
        $formPassword = $this->createForm(new MyChangePasswordFormType());
        if ($request->getMethod() == 'POST') {
            $formPassword->bind($request);
            if ($formPassword->isValid()) {
                $aChangePassword = $request->request->get('change_password');
                $sPassword = $aChangePassword['new']['first'];

                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $user->setPassword($encoder->encodePassword($sPassword, $user->getSalt()));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();


                $this->get('session')->getFlashBag()->add('success', "Mot de passe modifié est : '".$sPassword."' ");

                return new RedirectResponse($this->admin->generateUrl('list'));

            }
        }

        return $this->render('@ath_admin_path/User/password.html.twig', array(
                                'user'  => $user,
                                'form'         => $formPassword->createView()
                            ));
    }
}
