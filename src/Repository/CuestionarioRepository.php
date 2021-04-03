<?php

namespace App\Repository;

use App\Entity\Cuestionario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cuestionario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cuestionario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cuestionario[]    findAll()
 * @method Cuestionario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuestionarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cuestionario::class);
    }

    // /**
    //  * @return Cuestionario[] Returns an array of Cuestionario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cuestionario
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param $ministry
     * @return int|mixed|string
     */
    public function queryFindByMinistry($ministry)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.ministry = :val')
            ->setParameter('val', $ministry)
            ->orderBy('c.updatedAt', 'DESC')
            ;
    }
}
