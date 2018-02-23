<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 24/11/17
 * Time: 07:40
 */

namespace App\Controller\Security;

use App\Entity\User\User;
use Lch\UserBundle\Type\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResettingController extends Controller
{
	/**
	 * Step 1: Display a form to ask username
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function requestPassword()
	{
		return $this->render('@App/security/request-password.html.twig');
	}

	/**
	 * Step 2: Send a resetting password email to user
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse
	 */
	public function sendEmail(Request $request)
	{
		$username = $request->request->get('username');

		/** @var User $user */
		$user = $this->get('lch_user.manager')->findUserByUsername($username);

		if (null !== $user && !$user->isPasswordRequestNonExpired($this->getParameter('lch_user.resetting_ttl'))) {

			if (null === $user->getConfirmationToken()) {
				$user->setConfirmationToken($this->get('lch_user.token_generator')->generateToken());
			}

			// Send Email
			$this->get('lch_user.mailer')->sendResetPasswordEmail($user);

			$user->setPasswordRequestedAt(new \DateTime());
			$this->get('lch_user.manager')->updateUser($user);
		}

		return new RedirectResponse($this->generateUrl('app_check_email', ['username' => $username]));
	}

	/**
	 * Step 3: Inform user that an email has been sent
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function checkEmail(Request $request)
	{
		$username = $request->query->get('username');

		if (empty($username)) {
			// the user does not come from the sendEmail action
			// TODO remove fos stuff
			return new RedirectResponse($this->generateUrl('fos_user_resetting_request'));
		}

		return $this->render('@App/security/check-email.html.twig', array(
			'tokenLifetime' => ceil($this->getParameter('lch_user.resetting_ttl') / 3600),
		));
	}

	/**
	 * Step 4: Display a form for choose a new password
	 *
	 * @param Request $request
	 * @param $token
	 *
	 * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function reset(Request $request, $token)
	{
		$user = $this->get('lch_user.manager')->findUserByConfirmationToken($token);

		if (null === $user) {
			throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
		}

		$form = $this->createForm(ResetPasswordType::class, $user);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->get('lch_user.manager')->updateUserPassword($user);
			$this->get('lch_user.manager')->updateUser($user);

			return $this->redirectToRoute('app_login');
		}

		return $this->render('@App/security/reset-password.html.twig', [
			'form' => $form->createView(),
		]);
	}
}