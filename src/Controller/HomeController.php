<?php

namespace App\Controller;

use App\Entity\Fruit;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use stdClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $manager): Response
    {
        $book = new stdClass();
        $book->author = "Stewie McGriffin";
        $book->price = 39.99;
        $book->releasedate = "May 2023";

        $user = new stdClass();
        $user->name = "Robot001";
        $user->isConnected = true;

        $games = ["Noita" => 8,"Sonic 3" => 2, "Space Citizen Kane Skylines" => 1];

        $mango = new Fruit();
        $mango->setName("mango");
        $mango->setColour("orangetored");

        $manager->persist($mango);
        $manager->flush();


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'truc' => 'muche',
            'pagetype' => 'homepage',
            'what' => 'does the fox say ?',
            'book' => $book,
            'auteur' => $book->author,
            'user' => $user,
            'games' => $games
        ]);
    }
}
