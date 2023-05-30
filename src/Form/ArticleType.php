<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 5])],
                'label' => "Le titre de l'article",
                'attr' => ["placeholder" => "Titre..."] 
            ])
            ->add('intro', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 5])],
                'label' => "L'introduction de l'article",
                'attr' => ["placeholder" => "Intro..."]
            ])
            ->add('content', TextareaType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 100])],
                'label' => "Le contenu de l'article",
                'attr' => ["placeholder" => "Contenu..."] 
            ])
            ->add('image', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 5]),new Assert\Url([
                    'protocols' => ['http', 'https'],'message' => 'L\'URL {{ value }} est pas top.'])],
                'attr' => ["placeholder" => "https://..."]
            ])
            // ->add('author', EntityType::class, [
            //     'required' => false,
            //     'class' => User::class,
            //     'choice_label' => 'name'
            // ])
            ->add('Creer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

    // ...

    public function validateForm(ValidatorInterface $validator)
    {
        $article = new Article();

        // ... do something to the $artile object

        $errors = $validator->validate($article);

        if (count($errors) > 0) {
            /*
            * Uses a __toString method on the $errors variable which is a
            * ConstraintViolationList object. This gives us a nice string
            * for debugging.
            */
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        return new Response('The article is valid! Yes!');
    }
}
