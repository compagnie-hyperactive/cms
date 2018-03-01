<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 14/02/18
 * Time: 14:53
 */

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends BaseAdminController
{
    public function dashboard()
    {
    	# TODO Complete with what is needed for project
	    return $this->render('@App\admin\dashboard\index.html.twig');
    }
}