<?php

namespace App\Repository;

use App\Entity\FiltreData;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class ProduitRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Produit::class);
        $this->paginator =$paginator;
    }

    /**
     * @param FiltreData $filtreData
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function findSearch(FiltreData $filtreData): \Knp\Component\Pager\Pagination\PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('c','p')
            ->join('p.categorie','c');

        if(!empty($filtreData->q)){
            $query =$query
                ->andWhere('p.nomprod LIKE :q')
                ->setParameter('q',"%{$filtreData->q}%");
        }
        if (!empty($filtreData->min)){
            $query =$query
                ->andWhere('p.prix >= :min')
                ->setParameter('min',$filtreData->min);
            }
        if (!empty($filtreData->max)){
            $query =$query
                ->andWhere('p.prix >= :max')
                ->setParameter('max',$filtreData->min);
        }
        if (!empty($filtreData->promo)){
            $query =$query
                ->andWhere('p.promo = 1');
        }

        if (!empty($filtreData->categories)){
            $query =$query
                ->andWhere('c.id IN  (:categories)')
               ->setParameter('categories',$filtreData->categories);
        }

         $query=$query->getQuery();
        return $this->paginator->paginate(
            $query,
            1,
            11
        );
    }


    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p
                FROM AppBundle:Produit p
                WHERE p.nomprod LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
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
    public function findOneBySomeField($value): ?Produit
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
