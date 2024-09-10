<?php

namespace App\Repository;

use App\Entity\Cohorte;
use App\Entity\StudentFormation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;
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

    public function getUnpaidFormationByUser(User $user): array
    {
        return $this->findBy(['user' => $user, 'isTotalPaid' => false]);
    }

    public function getAllUnpaidFormations(Request $request): QueryBuilder
    {
        $search = $request->get('search');
        $query = $this->createQueryBuilder('s');

        if (!empty($search)) {
            $query->innerJoin('s.user', 'u');
            $query->orWhere('u.username LIKE :query');
            $query->orWhere('u.firstname LIKE :query');
            $query->orWhere('u.lastname LIKE :query');
            $query->setParameter('query', "%$search%");
        }

        $query->andWhere('s.isTotalPaid NOT LIKE :notPaid');
        $query->setParameter('notPaid', true);

        return $query;
    }

    public function switchUserStatus(StudentFormation $studentFormation): bool
    {
        $studentFormation->setConfirmed(!$studentFormation->isConfirmed());
        $this->getEntityManager()->flush();

        return true;
    }
}
