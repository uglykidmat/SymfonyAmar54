<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_index')]
    public function index(UserRepository $repo): Response
    {
        return $this->render('user/index.html.twig', [
            "users" => $repo->findAll()
            // 'controller_name' => 'ArticleController',
        ]);
    }

    #[Route('/user/new', name: 'user_create')]
    public function create(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->hashPassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success","L'utilisateur <strong>{$user->getFirstname()} {$user->getLastname()}</strong> a bien été créé !");

            return $this->redirectToRoute("user_show",[
                "id" => $user->getId()
            ]);
        }
        else if ($form->isSubmitted() && !$form->isValid()){
            $this->addFlash("danger","L'utilisateur <strong>{$user->getFirstname()} {$user->getLastname()}</strong> n'a pas pu être créé !");
            
        }

        // dump($user);
        
        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/{id}', name: 'user_show')]
    public function show($id, UserRepository $repo)
    {
        $user = $repo->findOneById($id);
        return $this->render('user/show.html.twig', [
            "user" => $user
        ]);
    }

    #[Route('/user/{id}/delete', name: 'user_delete')]
    public function delete($id, UserRepository $repo, EntityManagerInterface $manager){
        $user = $repo->findOneById($id);
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute("user_index",[
            $this->addFlash("warning","L'utilisateur a bien été supprimé... RIP")
        ]);
    }

    #[Route('/login', name: 'account_login')]
    public function login()
    {
        return $this->render('account/login.html.twig', [
        ]);
    }

    #[Route('/loginsuccess', name: 'account_loginsuccess')]
    public function loginsuccess()
    {
        return $this->render('account/loginsuccess.html.twig', [
            $this->addFlash("success","Bien connecté !")
        ]);
    }


    #[Route('/logout', name: 'account_logout')]
    public function logout()
    {
        // return $this->render('account/logout.html.twig', [
            
        // ]);
    }

    // TODO
    // #[Route('/user/{id}/edit', name: 'user_edit')]
    // public function edit($id, UserRepository $repo, EntityManagerInterface $manager){
    //     $user = $repo->findOneById($id);
    //     $manager->remove($user);
    //     $manager->flush();
    //     return $this->redirectToRoute("user_index",[
    //         $this->addFlash("warning","L'utilisateur a bien été supprimé... RIP")
    //     ]);
    // }
}