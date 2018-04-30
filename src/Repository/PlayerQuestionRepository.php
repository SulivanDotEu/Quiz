<?php

namespace App\Repository;

use App\Entity\PlayerQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PlayerQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerQuestion[]    findAll()
 * @method PlayerQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerQuestionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlayerQuestion::class);
    }

//    /**
//     * @return PlayerQuestion[] Returns an array of PlayerQuestion objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlayerQuestion
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
