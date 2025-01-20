<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function index(TeacherRepository $teacherRepository): Response
    {
        $teachers = $teacherRepository->findBy([], ["name" => "ASC"]);

        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
            'teachers' => $teachers,
        ]);
    }
    
    #[Route('/teacher/{id}', name: 'show_teacher')]
    public function show(Teacher $teacher): Response
    {
        return $this->render('teacher/show.html.twig', [
            'controller_name' => 'teacherController',
            'teacher' => $teacher,
        ]);
    }
}
