<?php

namespace App\DataFixtures;

use Faker\Factory;
use DateTimeImmutable;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        for ($i=1; $i <= 20 ; $i++) { 
            # code...
            $article=new Article();

            $title = $faker->sentence(2); // pour titre
            $image = $faker->imageUrl();
            $intro = $faker->paragraph(2);
            $content = '<p>'.implode('</p><p>', $faker->paragraphs(5)).'</p>';
            $createdAt = $faker->dateTimeBetween('-2 months');

            $article->setTitle($title);
            $article->setIntro($intro);
            $article->setContent($content);
            $article->setImage($image);

            //$articledate = new DateTimeImmutable();
            $article->setCreatedAt($createdAt);

            $manager->persist($article);
        }
        $manager->flush();
    }
}