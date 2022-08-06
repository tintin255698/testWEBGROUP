<?php

namespace App\Service;

use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Form extends AbstractController
{
    public $entityManager;
    public $articleRepository;

    public function __construct(EntityManagerInterface $entityManager, ArticleRepository $articleRepository)
    {
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Set data in form
     */
    public function setData($article):void
    {
        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }

    /**
     * Delete article
     */
    public function deleteData($article, $flash): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $this->entityManager->remove($article);
        $this->entityManager->flush();
        $this->addFlash('success', $flash);
        return $this->redirectToRoute('all_article');
    }

    /**
     * List all the articles
     */
    public function searchArticle($adresse):Response
    {
        return $this->render($adresse, [
            'alls' =>  $this->articleRepository->findAll()
        ]);
    }

    /**
     * List one article by ID
     */
    public function searchId($id): \App\Entity\Article
    {
        return $this->articleRepository->find($id);
    }


    /**
     * Form for register/edit
     */
    public function formArticle($request, $article, $slugger, $serviceForm, $flash):Response
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setSlug($slugger->slug($article->getTitle()));
            $serviceForm->setData($article);
            $this->addFlash('success', $flash);
            return $this->redirectToRoute('all_article');
        }

        return $this->render('admin/registerArticle.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}