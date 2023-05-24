<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 5])],
                'label' => "Prénom",
                'attr' => ["placeholder" => "Prénom..."] 
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 5])],
                'label' => "Nom",
                'attr' => ["placeholder" => "Nom..."]
            ])
            ->add('email', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 5]),new Assert\Email()],
                'label' => "eMail",
                'attr' => ["placeholder" => "eMail..."] 
            ])
            ->add('hash', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add('picture', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 5]),new Assert\Url([
                    'protocols' => ['http', 'https'],'message' => 'L\'URL {{ value }} est pas top.'])],
                'attr' => ["placeholder" => "https://..."]
            ])
            ->add('presentation', TextareaType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 5])],
                'label' => "Présentation",
                'attr' => ["placeholder" => "Présentation..."]
            ])
            ->add('Creer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    // ...

    public function validateForm(ValidatorInterface $validator)
    {
        $user = new User();
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            /*
            * Uses a __toString method on the $errors variable which is a
            * ConstraintViolationList object. This gives us a nice string
            * for debugging.
            */
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        return new Response("L'utilisateur est valide !");
    }
}
