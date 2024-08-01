<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputStyle = 'form-control form-control-user';

        $builder
            ->add(
                'firstname',
                TextType::class,
                [
                    'label' => 'Prénom',
                    'attr' => [
                        'class' => $inputStyle,
                    ],
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'label' => 'Nom',
                    'attr' => [
                        'class' => $inputStyle,
                    ],
                ]
            )
            ->add(
                'username',
                EmailType::class,
                [
                    'label' => 'Nom d\'utilisateur',
                    'attr' => [
                        'class' => $inputStyle,
                    ],
                ]
            )
            ->add('roles',
                ChoiceType::class,
                [
                    'choices' => User::ROLES,
                    'label' => 'Role',
                    'multiple' => true,
                    'expanded' => true,
                    'mapped' => false,
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'label' => 'Mots de passe',
                    'attr' => [
                        'class' => $inputStyle,
                    ],
                    'required' => false,
                    'mapped' => false,
                ]
            )
            ->add(
                'contact',
                ContactFormType::class,
                [
                    'label' => 'Contact'
                ]
            )
            ->add(
                'image',
                FileType::class, [
                    'label' => 'Photo de profil',
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'accept' => "image/*",
                        'class' => 'form-control'
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
