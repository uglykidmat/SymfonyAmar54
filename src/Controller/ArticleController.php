<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'articles_index')]
    #[IsGranted('ROLE_USER')]
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
        // $form->validateForm();

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setAuthor($this->getUser());

            $manager->persist($article);
            $manager->flush();

            $this->addFlash("success","L'article <strong>{$article->getTitle()}</strong> a bien été créé !");

            return $this->redirectToRoute("article_show",[
                "id" => $article->getId()
            ]);
        }
        else if ($form->isSubmitted() && !$form->isValid()){
            $this->addFlash("danger","L'article <strong>{$article->getTitle()}</strong> n'a pas pu être créé !");
            
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
    
    #[Route('/articles/{id}/edit', name: 'articles_edit')]
    #[Security("is_granted('ROLE_USER') and user === article.getAuthor()")]
    public function update($id, Article $article, ArticleRepository $repo, EntityManagerInterface $manager, Request $request):Response
    {
        $article = $repo->findOneById($id);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash("warning","L'article <strong>{$article->getTitle()}</strong> a bien été modifié !");
            return $this->redirectToRoute("article_show",[
                "id" => $article->getId()
            ]);
        }
        else if ($form->isSubmitted() && !$form->isValid()){
            $this->addFlash("danger","L'article <strong>{$article->getTitle()}</strong> n'a pas pu être modifié !");
        }

        return $this->render('article/edit.html.twig', [
            "articles" => $article,
            'form' => $form->createView()
            // 'controller_name' => 'ArticleController',
        ]);
    }

    #[Route('/articles/{id}/delete', name: 'articles_delete')]
    public function delete($id, ArticleRepository $repo, EntityManagerInterface $manager){
        $article = $repo->findOneById($id);
        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute("articles_index",[
            $this->addFlash("warning","L'article a bien été supprimé... RIP")
        ]);
    }
}