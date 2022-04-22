<?php

namespace App\Repository;

use App\Entity\Ticking;
use App\Entity\User;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ticking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticking[]    findAll()
 * @method Ticking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TickingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticking::class);
    }

    /**
     * @param Ticking $entity
     * @param bool $flush
     */
    public function add(Ticking $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Ticking $entity
     * @param bool $flush
     */
    public function remove(Ticking $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param User $user
     * @param DateTimeInterface $dateMin
     * @param DateTimeInterface $dateMax
     * @return mixed
     */
    public function getUserHistory(User $user, DateTimeInterface $dateMin, DateTimeInterface $dateMax)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.user = :user')
            ->setParameter('user', $user)
            ->andWhere('t.tickingDay >= :dateMin and t.tickingDay <= :dateMax')
            ->setParameter('dateMin', $dateMin)
            ->setParameter('dateMax', $dateMax)
            ->orderBy('t.tickingDay', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Ticking[] Returns an array of Ticking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ticking
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
