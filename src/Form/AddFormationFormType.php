<?php

namespace App\Form;

use App\Entity\Cohorte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('name',
                TextType::class,
                [
                    'label' => 'Formation name',
                    'attr' => ['class' => $inputStyle]

                ]
            )
            ->add(
                'alias',
                TextType::class,
                [
                    'label' => 'Alias',
                    'attr' => ['class' => $inputStyle]
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Description',
                    'attr' => [
                        'class' => $inputStyle,
                    ]
                ]
            )
            ->add('amount',
                IntegerType::class,
                [
                    'label' => 'Frais de formation',
                    'attr' => ['class' => $inputStyle]
                ]
            )
            ->add('startDate',
                DateType::class,
                [
                    'label' => 'Date début',
                    'widget' => 'single_text',
                    'attr' => ['class' => 'js-datepicker ' . $inputStyle],
                ]
            )
            ->add('endDate',
                DateType::class,
                [
                    'label' => 'Date fin',
                    'widget' => 'single_text',
                    'attr' => ['class' => 'js-datepicker ' . $inputStyle],
                    'constraints' => [
                        new GreaterThanOrEqual([
                            'message' => 'Please verify the date interval',
                            'propertyPath' => 'parent.all[startDate].data',
                        ]),
                    ],
                ]
            )
            ->add('cover',
                FileType::class, [
                    'label' => 'Photo de couverture',
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'accept' => "image/*"
                    ],
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