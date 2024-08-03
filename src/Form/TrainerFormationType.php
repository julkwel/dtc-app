<?php

namespace App\Form;

use App\Entity\TrainerFormation;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainerFormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('alias')
            ->add('description')
            ->add('trainer',
                EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'username',
                    'query_builder' => function (UserRepository $userRepository): QueryBuilder {
                        return $userRepository->createQueryBuilder('u')
                            ->andWhere('u.roles LIKE :role')
                            ->setParameter('role', "%ROLE_TRAINER%")
                            ->orderBy('u.username', 'ASC');
                    },
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrainerFormation::class,
        ]);
    }
}
