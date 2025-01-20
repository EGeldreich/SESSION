<?php

namespace App\Controller;

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
}
