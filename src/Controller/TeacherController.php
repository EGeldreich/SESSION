<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Repository\SessionRepository;
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
            'teachers' => $teachers,
        ]);
    }
    
    #[Route('/teacher/{id}', name: 'show_teacher')]
    public function show(Teacher $teacher, SessionRepository $sr): Response
    {
        $finishedSessions = $sr->findTeacherFinishedSessions($teacher->getId());
        $ongoingSessions = $sr->findTeacherOngoingSessions($teacher->getId());
        $futureSessions = $sr->findTeacherFutureSessions($teacher->getId());
        return $this->render('teacher/show.html.twig', [
            'teacher' => $teacher,
            'finishedSessions' => $finishedSessions,
            'ongoingSessions' => $ongoingSessions,
            'futureSessions' => $futureSessions,
        ]);
    }
}
