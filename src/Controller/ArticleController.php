<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute("article_show",[
                "id" => $article->getId()
            ]);
        }

        // dump($article);
        
        return $this->render('article/create.html.twig', [
            'form' => $form->createView()
        ]);
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

