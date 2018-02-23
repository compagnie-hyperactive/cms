<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 14/02/18
 * Time: 11:37
 */

namespace App\Controller\Security;

use Lch\UserBundle\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
	public function register(Request $request)
	{
		$user = $this->get('lch_user.manager')->create();
		$form = $this->createForm($this->getParameter('lch_user.forms.registration'), $user);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {

			// Finalize registration
			$this->get('lch_user.manager')->register($user);

			return $this->redirectToRoute('app_login');
		}

		return $this->render(
			'@App/security/registration.html.twig',
			array('form' => $form->createView())
		);
	}
}