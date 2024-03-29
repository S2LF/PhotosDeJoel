<?php

namespace App\Repository;

use App\Entity\Lien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lien[]    findAll()
 * @method Lien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LienRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Lien::class);
  }

  public function findAllOrderByPos()
  {
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
      "SELECT l
      FROM App\Entity\Lien l
      ORDER BY l.position ASC"
    );
    return $query->execute();
  }
}
