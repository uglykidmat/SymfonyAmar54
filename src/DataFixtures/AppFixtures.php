<?php

namespace App\DataFixtures;
use Faker\Factory;
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
            $article = new Article();
            $title = $faker->sentence(2); // pour titre
            $image = $faker->imageUrl();
            $intro = $faker->paragraph(2);
            $content = '<p>'.implode('</p><p>', $faker->paragraphs(5)).'</p>';

            $article->setTitle($title);
            $article->setIntro($intro);
            $article->setContent($content);
            $article->setImage($image);
            
            //$articledate = new DateTimeImmutable();
            // $article->setCreatedAt($createdAt);

            //COMMENT ON PEUT AVOIR L'ID ARGARGARG
            $manager->persist($article);
            $article->initSlug();
        }
        $manager->flush();
    }
}