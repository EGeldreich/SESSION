<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\SessionRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(StudentRepository $studentRepository): Response
    {
        $students = $studentRepository->findby([], ["name" => "ASC"]);

        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/student/new', name: 'new_student')]
    #[Route('/student/{id}/edit', name: 'edit_student')]
    public function new_edit(Student $student = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$student){
            $student = new Student();
        }

        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $student = $form->getData();

            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('show_student', ['id' => $student->getId()]);
        }

        return $this->render('student/new.html.twig', [
            'formNewStudent' => $form,
            'edit' => $student->getId(),
        ]);
    }

    #[Route('/student/{id}/delete', name: 'delete_student')]
    public function delete(Student $student, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($student);
        $entityManager->flush();

        return $this->redirectToRoute('app_student');
    }

    #[Route('/student/{id}/remove/{sessionId}', name: 'remove_student')]
    public function remove(Student $student = null, int $sessionId, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($student) {
            $session = $entityManager->getRepository(Session::class)->find($sessionId);
            if ($session) {
            $session->removeStudent($student);
            $entityManager->persist($session);
                $entityManager->flush();
                }
            }
        return $this->redirectToRoute('show_session', ['id' => $sessionId]);
    }

    #[Route('/student/{id}/add/{sessionId}', name: 'add_student')]
    public function add(Student $student = null, int $sessionId, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($student) {
            $session = $entityManager->getRepository(Session::class)->find($sessionId);
            if ($session) {
            $session->addStudent($student);
            $entityManager->persist($session);
                $entityManager->flush();
                }
            }
        return $this->redirectToRoute('show_session', ['id' => $sessionId]);
    }

    #[Route('/student/{id}', name: 'show_student')]
    public function show(Student $student, SessionRepository $sr): Response
    {
        $finishedSessions = $sr->findStudentFinishedSessions($student->getId());
        $ongoingSessions = $sr->findStudentOngoingSessions($student->getId());
        $futureSessions = $sr->findStudentFutureSessions($student->getId());
        return $this->render('student/show.html.twig', [
            'student' => $student,
            'finishedSessions' => $finishedSessions,
            'ongoingSessions' => $ongoingSessions,
            'futureSessions' => $futureSessions,
        ]);
    }

}
