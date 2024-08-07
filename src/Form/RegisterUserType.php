<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                "label" => "Nom",
            ])
            ->add('firstName', TextType::class, [
                "label" => "Prenom",
            ])
            ->add('email', EmailType::class, [
                "label" => "E-mail",
            ])
            ->add("plainPassword", RepeatedType::class, [
                'type' => PasswordType::class,
                "first_options" => [
                    "label" => "Votre mot de passe",
                    "hash_property_path" => "password",
                ],
                "second_options" => [
                    "label" => "confirmer votre mot de passe"
                ],
                "mapped" => false,
            ])
            ->add("save", SubmitType::class, [
                "label" => "Enregistrer",
                "attr" => [
                    "class" => "btn btn-primary"
                ]
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
