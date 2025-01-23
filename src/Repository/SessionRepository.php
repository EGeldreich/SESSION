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
            ->where('p.session = :id');

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

    // SESSIONS IN DIFFERENT STATES TIMEWISE __________________________________
    public function findFinishedSessions(): array
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('s')
            ->andWhere('s.dateEnd < :now')
            ->setParameter('now', $now)
            ->orderBy('s.dateEnd', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findOngoingSessions(): array
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('s')
            ->andWhere(':now BETWEEN s.dateStart AND s.dateEnd')
            ->setParameter('now', $now)
            ->orderBy('s.dateEnd', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findFutureSessions(): array
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('s')
            ->andWhere('s.dateEnd > :now')
            ->setParameter('now', $now)
            ->orderBy('s.dateEnd', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // SESSIONS RELATED TO EACH TEACHER __________________________________
    public function findTeacherFinishedSessions($teacherId): array
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('s')
            ->andWhere('s.dateEnd < :now')
            ->andWhere('s.teacher = :id')
            ->setParameter('id', $teacherId)
            ->setParameter('now', $now)
            ->orderBy('s.dateEnd', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findTeacherOngoingSessions($teacherId): array
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('s')
            ->andWhere(':now BETWEEN s.dateStart AND s.dateEnd')
            ->andWhere('s.teacher = :id')
            ->setParameter('id', $teacherId)
            ->setParameter('now', $now)
            ->orderBy('s.dateEnd', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findTeacherFutureSessions($teacherId): array
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('s')
            ->andWhere('s.dateEnd > :now')
            ->andWhere('s.teacher = :id')
            ->setParameter('id', $teacherId)
            ->setParameter('now', $now)
            ->orderBy('s.dateEnd', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // SESSIONS RELATED TO EACH STUDENT _______________________________________
    public function findStudentFinishedSessions($student_id): array
    {
        $now = new \DateTime();

        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.students', 'st')
            ->where('st.id = :studentId')
            ->andWhere('s.dateEnd < :now')
            ->setParameter('studentId', $student_id)
            ->setParameter('now', $now)
            ->orderBy('s.dateEnd', 'ASC')
            ->getQuery();

        return $qb->getResult();
    }
    public function findStudentOngoingSessions($student_id): array
    {
        $now = new \DateTime();

        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.students', 'st')
            ->where('st.id = :studentId')
            ->andWhere(':now BETWEEN s.dateStart AND s.dateEnd')
            ->setParameter('studentId', $student_id)
            ->setParameter('now', $now)
            ->orderBy('s.dateEnd', 'ASC')
            ->getQuery();

        return $qb->getResult();
    }
    public function findStudentFutureSessions($student_id): array
    {
        $now = new \DateTime();

        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.students', 'st')
            ->where('st.id = :studentId')
            ->andWhere('s.dateEnd > :now')
            ->setParameter('studentId', $student_id)
            ->setParameter('now', $now)
            ->orderBy('s.dateEnd', 'ASC')
            ->getQuery();

        return $qb->getResult();
    }
}
