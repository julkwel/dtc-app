<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'phone',
                TextType::class,
                [
                    'label' => 'Phone Number'
                ]
            )
            ->add(
                'facebook',
                TextType::class,
                [
                    'label' => 'Facebook (optional)',
                    'required' => false,
                ]
            )
            ->add(
                'linkedin',
                TextType::class,
                [
                    'label' => 'LinkedIn (optional)',
                    'required' => false,
                ]
            )
            ->add(
                'github',
                TextType::class,
                [
                    'label' => 'GitHub (optional)',
                    'required' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
