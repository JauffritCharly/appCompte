<?php

namespace App\Repository;

use App\Entity\ArgentEconomisees;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArgentEconomisees>
 *
 * @method ArgentEconomisees|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArgentEconomisees|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArgentEconomisees[]    findAll()
 * @method ArgentEconomisees[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArgentEconomiseesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArgentEconomisees::class);
    }

    public function save(ArgentEconomisees $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ArgentEconomisees $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ArgentEconomisees[] Returns an array of ArgentEconomisees objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ArgentEconomisees
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
