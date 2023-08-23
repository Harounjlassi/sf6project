<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personne>
 *
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

//    /**
//     * @return Personne[] Returns an array of Personne objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Personne
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    private function addintervaleAge(QueryBuilder $qb, $ageMin, $ageMax)
    {
        $qb->andWhere('p.age >= :ageMin and p.age <= :ageMax')
//            ->setParameter('ageMin', $ageMin)
//            ->setParameter('ageMax', $ageMax)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
            ->setParameters(['ageMin' => $ageMin, 'ageMax' => $ageMax]);
    }

    public function findPersonneByAgeInterval($ageMin, $ageMax)
    {
        $queryBuilder = $this->createQueryBuilder('p');
//           return $queryBuilder->andWhere('p.age >= :ageMin and p.age <= :ageMax')
////            ->setParameter('ageMin', $ageMin)
////            ->setParameter('ageMax', $ageMax)
////            ->orderBy('v.id', 'ASC')
////            ->setMaxResults(10)
//            ->setParameters(['ageMin'=> $ageMin,'ageMax'=> $ageMax])

        $this->addintervaleAge($queryBuilder, $ageMin, $ageMax);
        return $queryBuilder->getQuery()
            ->getResult();
    }


    public function statsPersonneByAgeInterval($ageMin, $ageMax)
    {
        $qb = $this->createQueryBuilder('p')
            ->select('avg(p.age) as ageMoyen, count(p.id) as nombrePersonne');
//        ->andWhere('p.age >= :ageMin and p.age <= :ageMax')
////            ->setParameter('ageMin', $ageMin)
////            ->setParameter('ageMax', $ageMax)
////            ->orderBy('v.id', 'ASC')
////            ->setMaxResults(10)
//        ->setParameters(['ageMin' => $ageMin, 'ageMax' => $ageMax])
        $this->addintervaleAge($qb, $ageMin, $ageMax);

        return $qb->getQuery()
            ->getScalarResult();


    }
}
