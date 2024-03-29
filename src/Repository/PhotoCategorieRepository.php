<?php

namespace App\Repository;

use App\Entity\PhotoCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoCategorie[]    findAll()
 * @method PhotoCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoCategorieRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, PhotoCategorie::class);
  }

  public function findAllOrderByPos()
  {
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
      "SELECT pc
      FROM App\Entity\PhotoCategorie pc
      ORDER BY pc.position ASC"
    );
    return $query->execute();
  }
}
