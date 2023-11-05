<?php

namespace App\Form;

use App\Entity\Cohorte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddFormationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $inputStyle = 'form-control';

        $builder
            ->add('startDate', DateType::class, [
                'label' => 'Start date',
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('endDate', DateType::class, [
                'label' => 'End date',
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('name', TextType::class, [
                'label' => 'Formation name',
                
            ])
            ->add('alias', TextType::class, [
                'label' => 'Alias',
                'attr' => ['class' => $inputStyle]
            ])
            ->add('amount', TextType::class, [
                'label' => 'Amount',
                'attr' => ['class' => $inputStyle]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cohorte::class,
        ]);
    }
}