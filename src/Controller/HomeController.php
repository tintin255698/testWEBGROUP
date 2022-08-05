<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Service\Form;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    public $serviceForm;

    public function __construct(Form $serviceForm)
    {
        $this->serviceForm = $serviceForm;
    }

    /**
     * @Route("", name="all")
     */
    public function articleByDateDesc(ArticleRepository $articleRepository): Response
    {
        return $this->render('homepage/homepage.html.twig', [
            'alls' =>$articleRepository->articleByDate()
        ]);
    }

    /**
     * @Route("/article/{id}-{slug}", name="detail_article")
     */
    public function detailArticle($id)
    {
        return $this->render('homepage/article.html.twig', [
            'articleDetail' =>$this->serviceForm->searchId($id)
        ]);
    }

}
