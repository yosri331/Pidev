<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

     /**
      * @return Event[] 
     */
    
    public function findByIdJoinedToReview(int $id): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT p, c
            FROM App\Entity\Event p
            INNER JOIN p.id_review c 
            WHERE p.id = :id ' 
        )->setParameter('id', $id);
        
        return $query->getResult();
        
    }
    /**
      * @return Event[] 
     */
    
    public function SortByDate(): array
    {
        $entityManager=$this->getEntityManager();
        $query = $entityManager->createQuery('SELECT p 
        FROM App\Entity\Event Order By date');
        return $query->getResult();
    
    }
    
    

    
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
