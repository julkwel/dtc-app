<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserFormType extends AbstractType
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
            ->add('image', FileType::class, [
                'label' => 'Profile picture',
                'mapped' => false,
                'required' => false,
            ])
            ->add('contacts', CollectionType::class, [
                'entry_type' => ContactFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
