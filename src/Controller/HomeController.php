<?php

namespace App\Controller;
use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $repo)
    {
        //$this->addFlash("Success","HEYO");
        return $this->render('home/index.html.twig', [
            "articles" => $repo->findLastArticles(3)
        ]);
    }
}
