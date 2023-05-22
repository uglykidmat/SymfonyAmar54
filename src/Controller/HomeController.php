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
        $image = $faker->imageUrl();
        $intro = $faker->paragraph(2);
        $content = '<p>'.implode('</p><p>', $faker->paragraphs(5)).'</p>';
        $createdAt = $faker->dateTimeBetween('-2 months', 'now');

        dump($title);
        dump($image);
        dump($content);
        return $this->render('home/index.html.twig', [
            "articles" => $repo->findLastArticles(3),
            "title" => $title,
            "imageFaker" => $image,
            "intro" => $intro,
            "content" => $content,
            "createdAt" => $createdAt
        ]);
    }
}
