<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputStyle = 'form-control form-control-user';

        $builder
            ->add(
                'firstname',
                TextType::class, [
                    'label' => 'Prénom',
                    'attr' => [
                        'class' => $inputStyle,
                    ],
                ]
            )
            ->add(
                'lastname',
                TextType::class, [
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
                    'label' => 'Mail',
                    'attr' => [
                        'class' => $inputStyle,
                    ],
                ]
            )
            ->add(
                'password',
                RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => [
                        'attr' => [
                            'autocomplete' => 'new-password',
                            'class' => $inputStyle,
                        ],
                    ],
                    'first_options' => [
                        'label' => 'Mots de passe',
                    ],
                    'second_options' => [
                        'label' => 'Entrer à nouveau votre mots de passe',
                        'attr' => [
                            'class' => $inputStyle,
                        ],
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, // Replace with your User entity class
        ]);
    }
}
