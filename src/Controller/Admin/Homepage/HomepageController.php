<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 14/02/18
 * Time: 14:53
 */

namespace App\Controller\Admin\Homepage;


use App\Controller\Admin\BaseAdminController;
use App\Entity\Site\Site;
use App\Form\Type\Homepage\HomepageType;

class HomepageController extends BaseAdminController
{
    public function homepageConfiguration()
    {
    	// Get site
	    $site = $this->getDoctrine()->getManager()->getRepository(Site::class)->find(1);
	    if(!$site instanceof Site) {
	    	$site = new Site();
	    }

	    $form = $this->createForm(HomepageType::class, $site);

	    return $this->render('@App\admin\homepage\index.html.twig', [
	    	'form' => $form->createView()
	    ]);
    }
}