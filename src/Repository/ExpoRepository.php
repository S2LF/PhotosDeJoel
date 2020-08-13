<?php

namespace App\Repository;

use App\Entity\Expo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Expo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expo[]    findAll()
 * @method Expo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expo::class);
    }

    public function findAllOrderByPos(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager ->createQuery(
                    "SELECT e
                        FROM App\Entity\Expo e
                        ORDER BY e.position ASC"
        );
        return $query->execute();
    }
    // /**
    //  * @return Expo[] Returns an array of Expo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Expo
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
