<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\Form;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminController extends AbstractController
{
    public $serviceForm;
    public $slugger;

    public function __construct(Form $serviceForm, SluggerInterface $slugger)
    {
        $this->serviceForm = $serviceForm;
        $this->slugger = $slugger;
    }

    /**
     * @Route("/admin/allArticle", name="all_article")
     */
    public function allArticle(ArticleRepository $articleRepository):Response{

        return $this->serviceForm->searchArticle('admin/allArticle.html.twig');
    }

    /**
     * @Route("/admin/registerArticle", name="register_article")
     */
    public function registerArticle(Request $request): Response
    {
        $article = new Article();

        return $this->serviceForm->formArticle($request, $article, $this->slugger, $this->serviceForm);
    }

    /**
     * @Route("/admin/{id}-{slug}", name="edit_article")
     */
    public function editArticle($id, Request $request):Response
    {
        $editId = $this->serviceForm->searchId($id);

        return $this->serviceForm->formArticle($request, $editId, $this->slugger, $this->serviceForm);
    }

    /**
     * @Route("/admin/{id}", name="delete_article")
     */
    public function deleteArticle($id):Response
    {
        $deleteId = $this->serviceForm->searchId($id);

        return  $this->serviceForm->deleteData($deleteId);
    }
}
