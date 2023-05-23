<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'articles_index')]
    public function index(ArticleRepository $repo): Response
    {
        return $this->render('article/index.html.twig', [
            "articles" => $repo->findAll()
            // 'controller_name' => 'ArticleController',
        ]);
    }

    #[Route('/articles/new', name: 'articles_create')]
    public function create(): Response
    {
        return $this->render('article/create.html.twig', []);
    }

    #[Route('/articles/{id}', name: 'article_show')]
    public function show($id, ArticleRepository $repo)
    {
        // $article = $repo->findOneById($id);
        // return $this->render('article/show.html.twig', [
        //     "article" => $article
        // ]);

        $article = $repo->findOneById($id);
        return $this->render('article/show.html.twig', [
            "article" => $article
        ]);
    }
}

