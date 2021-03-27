<?php

namespace App\Repository;

use App\Entity\ValorRespuesta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ValorRespuesta|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValorRespuesta|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValorRespuesta[]    findAll()
 * @method ValorRespuesta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValorRespuestaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ValorRespuesta::class);
    }

    // /**
    //  * @return ValorRespuesta[] Returns an array of ValorRespuesta objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ValorRespuesta
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
