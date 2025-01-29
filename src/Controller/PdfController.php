<?php

namespace App\Controller;

use App\Entity\Student;
use App\Service\DompdfService;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PdfController extends AbstractController
{
    #[Route('/pdf/generate/student/{id}', name: 'generate_pdf')]
    public function generatePdf(Student $student,
    DompdfService $dompdfService,
    SessionRepository $sr): Response
    {
        $finishedSessions = $sr->findStudentFinishedSessions($student->getId());
        $ongoingSessions = $sr->findStudentOngoingSessions($student->getId());
        $futureSessions = $sr->findStudentFutureSessions($student->getId());

        $html = $this->renderView('pdf/studentTemplate.html.twig', [
            'student' => $student,
            'finishedSessions' => $finishedSessions,
            'ongoingSessions' => $ongoingSessions,
            'futureSessions' => $futureSessions,
        ]);

        $dompdfService->showPdfFile($html, 'student_session_planner.pdf');

        return new Response('', 200, [
            'Content-Type' => 'application/pdf'
        ]);
    }
}
