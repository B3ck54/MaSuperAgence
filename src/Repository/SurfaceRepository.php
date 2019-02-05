<?php

namespace App\Repository;

use App\Entity\Surface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Surface|null find($id, $lockMode = null, $lockVersion = null)
 * @method Surface|null findOneBy(array $criteria, array $orderBy = null)
 * @method Surface[]    findAll()
 * @method Surface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurfaceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Surface::class);
    }

    // /**
    //  * @return Surface[] Returns an array of Surface objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Surface
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
