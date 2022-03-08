<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;


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
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Event $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Event $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Event[] Returns an array of Event objects
     */
    
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
    
    
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function FindAllSearch(Event $event){
        $qb=$this->_getAndSearchParameters($event);
        $qb->setParameters($this->_getParams($event));
       
        
        
    }
    public function _getAndSearchParameters(Event $event){
        $qb=$this->createQueryBuilder('event');
        $and=$qb->expr()->andX();
        if(!empty($event->getNom())){
            $and->add($qb->expr()->eq('event.nom',':nom'));
        
        }
        if(!empty($event->getDescription())){
            $and->add($qb->expr()->eq('event.description',':description'));
        }
         if(!empty($event->getUtilisateur())){
            $and->add($qb->expr()->eq('event.organiseur',':organiseur'));}
            if(count($and->getParts())>0){
                return $qb->where($and);
            }
    }
    public function _getParams(Event $event){
        $params=array();
        if(!empty($event->getNom())){
            $params['nom']=$event->getNom();
        }
        if(!empty($event->getDescription())){
            $params['description']=$event->getDescription();
        }
        if(!empty($event->getUtilisateur())){
            $params['organiseur']=$event->getUtilisateur();
        }
        return $params;
    }
    public function multiSearch($filter){
        return $this->createQueryBuilder("a")
        ->andWhere('a.id LIKE :id OR a.nom  LIKE :nom OR a.description LIKE :description OR a.utilisateur like :organiseur')
        ->setParameters([
            'id' =>'%' . $filter . '%',
            'nom' => '%' . $filter . '%',
            'description' => '%' . $filter . '%',
            'organiseur' => '%' . $filter . '%'
        ])->getQuery()->execute();
  
    }
    public function SearchByName($filter) {
        
        $qb=$this->createQueryBuilder('e')
        ->where('e.nom = :nom')
        ->orWhere('e.description = :nom')
        ->orWhere('e.utilisateur = :nomuser')
        ->orWhere('e.id = :nom')
        ->setParameters(['nom'=> $filter ,'nomuser' => $filter])
        ->getQuery();
        return $qb->execute();

    }
    
}
