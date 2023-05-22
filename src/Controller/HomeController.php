<?php

namespace App\Controller;

use Faker\Factory;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $repo)
    {
        $faker = Factory::create("fr_FR");
        $title = $faker->text();
        dump($title);
        return $this->render('home/index.html.twig', [
            "articles" => $repo->findLastArticles(3)
        ]);
    }
}
