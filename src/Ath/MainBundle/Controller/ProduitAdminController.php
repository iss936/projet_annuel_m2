<?php

namespace Ath\MainBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Request;

class ProduitAdminController extends Controller
{

    public function editAction($id = null)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        $securityContext = $this->get('security.context');

        if(!$securityContext->isGranted('ROLE_ADMIN_PRODUIT'))
        {
            $user = $this->getUser();
            $produit = $this->admin->getSubject();

            // on peut edité le produit que si on est le créateur
            if($produit)
            {
                if($produit->getCreatedBy() != $user)
                    throw new AccessDeniedHttpException("Vous n'avez pas les droits nécéssaires pour accéder cette page");
            }
        }

        return parent::editAction($id);
    }

    public function deleteAction($id = null)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        $securityContext = $this->get('security.context');

        if(!$securityContext->isGranted('ROLE_ADMIN_PRODUIT'))
        {
            $user = $this->getUser();
            $produit = $this->admin->getSubject();

            // on peut edité le produit que si on est le créateur
            if($produit)
            {
                if($produit->getCreatedBy() != $user)
                    throw new AccessDeniedHttpException("Vous n'avez pas les droits nécéssaires pour accéder cette page");
            }
        }

        return parent::deleteAction($id);
    }
}