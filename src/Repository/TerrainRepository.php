<?php

namespace App\Repository;

use App\Entity\Terrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Terrain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Terrain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Terrain[]    findAll()
 * @method Terrain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Terrain::class);
    }

     /**
      * @return Terrain[] Returns an array of Terrain objects
      */

    public function searchStatus($status)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.status LIKE :a')
            ->setParameter('a', '%'.$status.'%')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
 * Returns number of "terrains" per date
 * @Return void
 */
public function countByDate(){
    $query=$this->createQueryBuilder('a')
        ->select('SUBSTRING(a.updatedAt,1 , 10) as dateCreation,
         COUNT(a) as count')
        ->groupBy('dateCreation');
    return $query->getQuery()->getResult();
}


    /*
    public function findOneBySomeField($value): ?Terrain
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}