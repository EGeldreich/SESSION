<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function findNonRegisteredStudents($session_id): array
    {
        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        $qb = $sub;
        // select all students already registered in a session
        $qb->select('s')
            ->from('App\Entity\Student', 's')
            ->leftJoin('s.sessions', 'se')
            ->where('se.id = :id');

        $sub = $em->createQueryBuilder();
        // select all students, minus those already registered in the session
        $sub->select('st')
            ->from('App\Entity\Student', 'st')
            ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
            ->setParameter('id', $session_id)
            ->orderBy('st.name', 'ASC');

        $query = $sub->getQuery();
        return $query->getResult();
    }

    public function findNonScheduledLessons($session_id): array
    {
        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        $qb = $sub;
        // select all lessons already scheduled in a session
        $qb->select('l')
            ->from('App\Entity\Lesson', 'l')
            ->leftJoin('l.programs', 'p')
            ->where('l.id = :id');

        $sub = $em->createQueryBuilder();
        // select all lessons, minus those already scheduled in the session
        $sub->select('le')
            ->from('App\Entity\Lesson', 'le')
            ->where($sub->expr()->notIn('le.id', $qb->getDQL()))
            ->setParameter('id', $session_id)
            ->orderBy('le.name', 'ASC');
        
        $query = $sub->getQuery();
        return $query->getResult();
    }
    //    /**
    //     * @return Session[] Returns an array of Session objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
