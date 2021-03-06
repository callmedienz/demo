<?php

namespace App\Repository;

use App\Entity\Mobile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mobile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mobile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mobile[]    findAll()
 * @method Mobile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MobileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mobile::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Mobile $entity, bool $flush = true): void
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
    public function remove(Mobile $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return Mobile[]  
    */
    public function sortId ()
    {
        // SQL: SELECT * FROM Mobile ORDER BY id DESC
        // DQL: Doctrine Query Language
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

     /**
    * @return Mobile[]  
    */
    public function sortQuantityAsc ()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.quantity', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

     /**
    * @return Mobile[]  
    */
    public function sortQuantityDesc ()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.quantity', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Mobile[]
     */
    //relative search : t??m ki???m t????ng ?????i (LIKE, %)
    //absolute search : t??m ki???m tuy???t ?????i (=)
    public function searchByName ($keyword)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.name LIKE :key')
            ->setParameter('key', '%' . $keyword . '%')
            ->orderBy('m.name', 'ASC') //optional
            ->setMaxResults(3) //optional
            ->getQuery()
            ->getResult()
        ;
    }

}