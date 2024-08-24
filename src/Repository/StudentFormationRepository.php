<?php

namespace App\Repository;

use App\Entity\Cohorte;
use App\Entity\StudentFormation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<StudentFormation>
 *
 * @method StudentFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentFormation[]    findAll()
 * @method StudentFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentFormation::class);
    }

    public function saveNewStudentFormation(UserInterface $user, Cohorte $cohorte): bool
    {
        if ($this->findOneBy(['user' => $user, 'formation' => $cohorte])) {
            throw new Exception('Vous êtes déjà inscrit sur ce formation !');
        }

        $userFormation = new StudentFormation();
        $userFormation->setFormation($cohorte);
        $userFormation->setUser($user);

        $this->getEntityManager()->persist($userFormation);
        $this->getEntityManager()->flush();

        return true;
    }

    public function getUnpaidFormation(User $user): array
    {
        return $this->findBy(['user' => $user, 'isTotalPaid' => false]);
    }

    public function switchUserStatus(StudentFormation $studentFormation)
    {
        $studentFormation->setConfirmed(!$studentFormation->isConfirmed());
        $this->getEntityManager()->flush();

        return true;
    }
}
