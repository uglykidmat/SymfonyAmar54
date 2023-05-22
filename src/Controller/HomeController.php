<?php

namespace App\Controller;
use Cocur\Slugify\Slugify;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $repo)
    {
        $slugify = new Slugify();
        $title = "ya ya oléo ASD123 CAP..I#Iö";
        dump($slugify->slugify($title));

        $article = $repo->findOneById(121);
        dump($article);

        return $this->render('home/index.html.twig', [
            "articles" => $repo->findLastArticles(3)
        ]);
    }
}
