<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class Form
{
    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setData($article):void
    {
        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }

    public function deleteData($article)
    {
        $this->entityManager->remove($article);
        $this->entityManager->flush();

    }


}