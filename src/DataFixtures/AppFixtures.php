<?php

namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        $genres = ['male','female'];
        $users = [];

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $userRole = new Role();
        $userRole->setTitle('ROLE_USER');
        $manager->persist($userRole);

        $adminUser = new User();
        $adminUser->setFirstname("Root")
                ->setLastname("Admin")
                ->setEmail("overlord@hivemind.com")
                ->setPicture("https://cdn001.tintin.com/public/tintin/img/characters/dupond-et-dupont/dupond-et-dupont.png")
                ->setPresentation("No introduction needed.")
                ->setHash($this->encoder->hashPassword($adminUser, "password"))
                ->addUserRole($adminRole);
        $manager->persist($adminUser);

        for ($i=1; $i <= 20 ; $i++) { 
        $user = new User();
            $genre = $faker->randomElement($genres);
            $picture = "https://randomuser.me/api/portraits/";
            $pictureId = $faker->numberBetween(1,99).".jpg";
            $picture .= ($genre == "male" ? "men/" : "women/").$pictureId;

            
            $user->setFirstname($faker->firstName($genre))
                ->setLastname($faker->lastName())
                ->setEmail($faker->email)
                ->setPicture($picture)
                ->setPresentation($faker->sentence())
                ->setHash($this->encoder->hashPassword($user, "password"))
                ->addUserRole($userRole);   
            
            //COMMENT ON PEUT AVOIR L'ID ARGARGARG
            $manager->persist($user);
            $users[] = $user;
            $user->initSlug();
        }

        for ($i=1; $i <= 20 ; $i++) { 
            $article = new Article();
            $title = $faker->sentence(2); // pour titre
            $image = $faker->imageUrl();
            $intro = $faker->paragraph(2);
            $content = '<p>'.implode('</p><p>', $faker->paragraphs(5)).'</p>';

            $author = $users[mt_rand(0, count($users)-1)];
            
            $article->setTitle($title);
            $article->setIntro($intro);
            $article->setContent($content);
            $article->setImage($image);
            $article->setAuthor($author);

            //COMMENT ON PEUT AVOIR L'ID ARGARGARG
            $manager->persist($article);
            $article->initSlug();
        }
        $manager->flush();
    }
}