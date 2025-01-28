<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    #[Route('/handlesearch/{sessionId}', name: 'student_search')]
    public function searchStudent(int $sessionId,
    StudentRepository $sr,
    Request $request,
    SessionInterface $si): Response
    {
        $query = $request->request->get('search_input');

        $searchInput = filter_var($query, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $students = null;
        if($searchInput) {
            $students = $sr->findStudents($sessionId, $searchInput);
        }

        $si->set('searchResult', $students);
        // dd($students);

        return $this->redirectToRoute('show_session', [
            'id' => $sessionId,
        ]);

    }
}
