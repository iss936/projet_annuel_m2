<?php

namespace Ath\UserBundle\Managers;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{

	protected $router;
	protected $security;
	private $session;

	public function __construct(Router $router, SecurityContext $security,  Session $session)
	{
		$this->router 	= $router;
		$this->security = $security;
		$this->session 	= $session;
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token)
	{

		if ($this->security->isGranted('ROLE_SUPER_ADMIN') || $this->security->isGranted('ROLE_ADMIN')) {
          // $response = new RedirectResponse($this->router->generate(''));
            $response = new RedirectResponse($this->router->generate('ath_user_homepage'));
        }
        elseif ($this->security->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->router->generate('ath_user_homepage'));
        }

		return $response;
	}

}
