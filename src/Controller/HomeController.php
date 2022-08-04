<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("", name="app_nav_bar")
     */
    public function index(): Response
    {
        return $this->render('HomePage/homepage.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
