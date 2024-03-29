<?php

namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Photo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photo[]    findAll()
 * @method Photo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Photo::class);
  }

  public function findAllOrderByPos()
  {
    $entityManager = $this->getEntityManager();
    $query = $entityManager->createQuery(
      "SELECT p
      FROM App\Entity\Photo p
      ORDER BY p.position ASC"
    );
    return $query->execute();
  }

  public function getPhotoCatByPos($catId)
  {
    return $this->createQueryBuilder('p')
      ->where('p.photo_categorie = ' . $catId)
      ->orderBy('p.position', 'ASC')
      ->getQuery()
      ->getResult();
  }
}
