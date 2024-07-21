<?php

namespace App\Form;

use App\Entity\Cohorte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class AddFormationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $inputStyle = 'form-control';

        $builder
            ->add('startDate', DateType::class, [
                'label' => 'Start date',
                'widget' => 'single_text',
                  'attr' => ['class' => 'js-datepicker ' . $inputStyle],
            ])
            ->add('endDate', DateType::class, [
                'label' => 'End date',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker ' . $inputStyle],
                'constraints' => [
                new GreaterThanOrEqual([
                    'message' => 'Please verify the date interval',
                    'propertyPath' => 'parent.all[startDate].data',
                ]),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Formation name',
                'attr' => ['class' => $inputStyle]
                
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