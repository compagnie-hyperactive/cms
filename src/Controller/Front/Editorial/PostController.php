<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 02/03/18
 * Time: 12:05
 */

namespace App\Controller\Front\Editorial;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller {


	public function show(Request $request, $slug) {
		return $this->render('@App/front/editorial/post.show.html.twig');
	}
}