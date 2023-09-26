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
            ->add('phone', TextType::class, [
                'label' => 'Phone Number',
            ])
            ->add('facebook', TextType::class, [
                'label' => 'Facebook Profile (optional)',
                'required' => false,
            ])
            ->add('linkedin', TextType::class, [
                'label' => 'LinkedIn Profile (optional)',
                'required' => false,
            ])
            ->add('github', TextType::class, [
                'label' => 'GitHub Profile (optional)',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email (optional)',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
