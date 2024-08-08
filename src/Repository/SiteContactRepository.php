<?php

namespace App\Repository;

use App\Entity\SiteContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SiteContact>
 */
class SiteContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteContact::class);
    }

    /**
     * @throws Exception
     */
    public function findNotViewMessage(): int
    {
        $query = 'SELECT COUNT(*) FROM site_contact WHERE is_view IS NOT true';
        $stmt = $this->getEntityManager()->getConnection()->prepare($query);

        return $stmt->executeQuery()->rowCount();
    }
}
