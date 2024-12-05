<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormConfigInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Votre Mot de passe Actuel',
                'mapped' => false,
            ])
            ->add("plainPassword", RepeatedType::class, [
                'type' => PasswordType::class,
                "first_options" => [
                    "label" => "Votre nouveau mot de passe",
                    "hash_property_path" => "password",
                ],
                "second_options" => [
                    "label" => "confirmer votre nouveau mot de passe"
                ],
                "mapped" => false,
            ])
            ->add('save', SubmitType::class, [
                'label'=> 'Enregistrer', 
                'attr' => [
                    "class" => 'btn btn-success'
                ]
            ])
            ->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) use ($options)  {
                $user = $options["user"];
                $hasher = $options["hasher"];
                $form = $event->getForm();
                $currentPassword = $form->get('currentPassword');

                $isPwdMatch = $hasher->isPasswordValid($user, $currentPassword->getData());

               if(!$isPwdMatch) {
                    $currentPassword->addError(new FormError('Le mot de passe ne correspond pas'));
               }
              
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => User::class,
            'user' => null,
            'hasher' => null,
        ]);
    }
}
