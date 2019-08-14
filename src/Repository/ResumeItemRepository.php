<?php

namespace App\Repository;

use App\Entity\ResumeItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ResumeItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResumeItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResumeItem[]    findAll()
 * @method ResumeItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResumeItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ResumeItem::class);
    }

    // /**
    //  * @return ResumeItem[] Returns an array of ResumeItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResumeItem
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
