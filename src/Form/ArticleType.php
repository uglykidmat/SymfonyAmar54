<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                // 'placeholder'=>  "Le titre de l'article",
                'label' => "Le titre de l'article",
                'attr' => ["placeholder" => "Titre..."] 
            ])
            ->add('intro', TextType::class, [
                'label' => "L'introduction de l'article",
                'attr' => ["placeholder" => "Intro..."]
            ])
            ->add('content', TextareaType::class, [
                'label' => "Le contenu de l'article",
                'attr' => ["placeholder" => "Contenu..."] 
            ])
            ->add('image', TextType::class, [
                'attr' => ["placeholder" => "https://..."]
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
