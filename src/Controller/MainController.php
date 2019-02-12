<?php
/**
 * Created by PhpStorm.
 * User: ravgus
 * Date: 12.02.19
 * Time: 10:30
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_index")
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }
}