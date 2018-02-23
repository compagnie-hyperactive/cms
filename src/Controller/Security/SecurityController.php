<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 22/11/17
 * Time: 07:17
 */

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller {
	/**
	 * @param AuthenticationUtils $authUtils
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function login( AuthenticationUtils $authUtils ) {
		$error = $authUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authUtils->getLastUsername();

		$form = $this->createForm(
			$this->getParameter( 'lch_user.forms.login' ),
			null,
			[ 'last_username' => $lastUsername ]
		);

		return $this->render( '@App/security/login.html.twig', [
			'error' => $error,
			'form'  => $form->createView()
		] );
	}
}