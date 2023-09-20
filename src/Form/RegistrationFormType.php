<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
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
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                    'placeholder' => 'Firstname',
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                    'placeholder' => 'Lastname',
                ],
            ])
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => $inputStyle,
                    'placeholder' => 'Username',
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => $inputStyle,
                        'placeholder' => 'Password',
                    ],
                ],
                'first_options' => ['label' => false],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => $inputStyle,
                        'placeholder' => 'Repeat password',
                    ],
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, // Replace with your User entity class
        ]);
    }
}
