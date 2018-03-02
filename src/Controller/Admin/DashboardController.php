<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 14/02/18
 * Time: 14:53
 */

namespace App\Controller\Admin;


class DashboardController extends BaseAdminController
{
    public function dashboard()
    {
    	# TODO Complete with what is needed for project
	    return $this->render('@App\admin\dashboard\index.html.twig');
    }
}