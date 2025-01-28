<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function findStudents(int $session_id, string $query): array
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
        // Select students related to query input, minus those already registered in the session
        $sub->select('st')
            ->from('App\Entity\Student', 'st')
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->like('st.firstname', ':query'),
                    $qb->expr()->like('st.name', ':query'),
                    $qb->expr()->like('st.city', ':query'),
                )
            )
            ->setParameter('query', '%' . $query . '%')
            ->andWhere($sub->expr()->notIn('st.id', $qb->getDQL()))
            ->setParameter('id', $session_id)
            ->orderBy('st.name', 'ASC');

        $query = $sub->getQuery();
        return $query->getResult();
    }

    //    /**
    //     * @return Student[] Returns an array of Student objects
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

    //    public function findOneBySomeField($value): ?Student
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    
}
