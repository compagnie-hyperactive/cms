<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 05/02/18
 * Time: 17:07
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function index ()
    {
        return $this->render('main.html.twig');
    }
}