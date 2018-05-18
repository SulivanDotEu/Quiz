<?php

namespace App\Repository;

use App\Entity\PlayerChoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PlayerChoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerChoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerChoice[]    findAll()
 * @method PlayerChoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerChoiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlayerChoice::class);
    }

//    /**
//     * @return PlayerChoice[] Returns an array of PlayerChoice objects
//     */
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
    public function findOneBySomeField($value): ?PlayerChoice
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
