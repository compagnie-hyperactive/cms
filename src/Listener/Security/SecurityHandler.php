<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 27/02/18
 * Time: 17:30
 */

namespace App\Listener\Security;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class SecurityHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{

	private $router;

	public function __construct(RouterInterface $router)
	{
		$this->router = $router;
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token)
	{
		// only an example, make your own logic here
//		$referer = $request->headers->get('referer');
//		if (empty($referer)) {

		// TODO make necessary check to ensure proper redirection after successful authentication

			return new RedirectResponse($this->router->generate('index'));
//		} else {
//			return new RedirectResponse($referer);
//		}
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
//		$request->getSession()->set('login_error', $error);
		// TODO make necessary check to ensure proper redirection after failure authen authentication
		return new RedirectResponse($this->router->generate('app_login'));
	}

}