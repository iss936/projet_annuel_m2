<?php

namespace Ath\MainBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\TranslatorInterface as Translator;
use Ath\MainBundle\Entity\FilePost;

class PostFormHandler
{
    protected $request;
    protected $em;
    protected $session;
    protected $translator;

    public function __construct(Request $request, ObjectManager $em, Session $session, Translator $translator)
    {
        $this->request = $request;
        $this->em      = $em;
        $this->session = $session;
        $this->translator = $translator;
    }

    public function process(Form $form)
    {
        if ('POST' === $this->request->getMethod()) {
            $form->bind($this->request);
                
            if ($form->isValid()) {
                $post = $form->getData();
                $this->em->persist($post);
                
                if ($post->getFile()) {
                    $filePost = new FilePost();
                    $filePost->setFile($post->getFile());
                    $filePost->setPost($post);
                    $this->em->persist($filePost);
                }
                
                $this->em->flush();

                return true;
            }
        }
        return false;
    }
}
