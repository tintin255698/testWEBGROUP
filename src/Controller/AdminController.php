<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
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

        return $this->render('admin/allArticle.html.twig', [
            'alls' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/registerArticle", name="register_article")
     */
    public function registerArticle(Request $request): Response
    {
        $article = new Article();

        return $this->formArticle($request, $article);
    }

    /**
     * @Route("/admin/{id}-{slug}", name="edit_article")
     */
    public function editArticle($id, ArticleRepository $articleRepository, Request $request):Response
    {
        $editId = $articleRepository->find($id);

        return $this->formArticle($request, $editId);
    }

    /**
     * Return register/edit form
     */
    public function formArticle($request, $article):Response
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setSlug($this->slugger->slug($article->getTitle()));
            $this->serviceForm->setData($article);
            return $this->redirectToRoute('all_article');
        }

        return $this->render('admin/registerArticle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="delete_article")
     */
    public function deleteArticle($id, ArticleRepository $articleRepository){
        $deleteId = $articleRepository->find($id);

        $this->serviceForm->deleteData($deleteId);

        return $this->redirectToRoute('all_article');
    }


}
