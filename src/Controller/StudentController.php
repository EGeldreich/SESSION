<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\StudentRepository;
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
            'controller_name' => 'StudentController',
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

            return $this->redirectToRoute('app_student');
        }

        return $this->render('student/new.html.twig', [
            'controller_name' => 'StudentController',
            'formNewStudent' => $form,
            'edit' => $student->getId(),
        ]);
    }

    #[Route('/student/{id}', name: 'show_student')]
    public function show(Student $student): Response
    {
        return $this->render('student/show.html.twig', [
            'controller_name' => 'StudentController',
            'student' => $student,
        ]);
    }

}
