<?php

namespace App\Repository;

use App\Entity\Actualite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Actualite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actualite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actualite[]    findAll()
 * @method Actualite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualiteRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Actualite::class);
  }


  public function findAllOrderByPos()
  {
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
      "SELECT a
      FROM App\Entity\Actualite a
      ORDER BY a.position ASC"
    );
    return $query->execute();
  }
}
