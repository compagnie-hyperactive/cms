<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 02/03/18
 * Time: 10:58
 */

namespace App\Controller\Admin\User;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class UserController extends BaseAdminController
{
    public function selfShowAction()
    {
        $user = $this->getUser();

        return $this->render('app/admin/User/selfShow.html.twig', [
            'user' => $user,
        ]);
    }
}