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

    public function findAllOrderByPos(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager ->createQuery(
                    "SELECT c
                        FROM App\Entity\PhotoCategorie c
                        ORDER BY c.position ASC"
        );
        return $query->execute();
    }
    // /**
    //  * @return PhotoCategorie[] Returns an array of PhotoCategorie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PhotoCategorie
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
