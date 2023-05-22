<?php

namespace App\Controller;

use stdClass;
use App\Entity\Fruit;
use Doctrine\ORM\EntityManager;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $repo)
    {
        dump($repo->findLastArticles());
        return $this->render('home/index.html.twig', []);
    }
}
