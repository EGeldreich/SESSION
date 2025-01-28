<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Session;
use App\Entity\Student;
use App\Form\ProgramType;
use App\Form\SessionType;
use Doctrine\ORM\EntityManager;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sr): Response
    {
        $sessions = $sr->findBy([], ["dateStart" => "ASC"]);

        $finishedSessions = $sr->findFinishedSessions();
        $ongoingSessions = $sr->findOngoingSessions();
        $futureSessions = $sr->findFutureSessions();

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
            'finishedSessions' => $finishedSessions,
            'ongoingSessions' => $ongoingSessions,
            'futureSessions' => $futureSessions,
        ]);
    }

    #[Route('/session/new', name: 'new_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function new_edit(Session $session = null,
    Request $request,
    EntityManagerInterface $entityManager): Response
    {
        if(!$session){
            $session = new Session();
        }

        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();

            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
        }

        return $this->render('session/new.html.twig', [
            'formNewSession' => $form,
            'edit' => $session->getId(),
        ]);
    }

    #[Route('/session/{id}/delete', name: 'delete_session')]
    public function delete(Session $session,
    EntityManagerInterface $entityManager)
    {
        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute('app_session');
    }

    
    #[Route('/program/{id}/remove/{sessionId}', name: 'remove_lesson')]
    public function removeLesson(Program $program = null,
    int $sessionId,
    EntityManagerInterface $entityManager,
    Request $request): Response
    {
        if ($program) {
            $session = $entityManager->getRepository(Session::class)->find($sessionId);
            if ($session) {
                $entityManager->remove($program);
                $entityManager->flush();
                }
            }
        return $this->redirectToRoute('show_session', ['id' => $sessionId]);
    }

    #[Route('/session/{id}', name: 'show_session')]
    public function show(Session $session = null,
    SessionRepository $sr,
    Request $request,
    EntityManagerInterface $entityManager,
    SessionInterface $si): Response
    {
        if(!$session){
            return $this->redirectToRoute('app_session');
        }

        $nonRegisteredStudents = $sr->findNonRegisteredStudents($session->getId());
        $nonScheduledLessons = $sr->findNonScheduledLessons($session->getId());

        // Get SearchResult from session, or null if not set
        $searchResult = $si->get('searchResult', null);
        // Clean session
        $si->remove('searchResult');

        // Define modalOpen default state
        $modalOpen = !empty($searchResult);

        // Form to add lessons to session
        $formAddLessons = $this->createForm(ProgramType::class, null, [
            'nonScheduledLessons' => $nonScheduledLessons,
        ]);

        $formAddLessons->handleRequest($request);
        if ($formAddLessons->isSubmitted() && $formAddLessons->isValid()) {
            $programs = $formAddLessons->getData()['programs'];

            // Check for duplicate entries
            // create empty array
            $lessons = [];
            foreach ($programs as $program) {
                // get lesson id
                $lessonId = $program->getLesson()->getId();
                // check if lesson id is in array
                if (in_array($lessonId, $lessons)) {
                    // if it is, duplicate entry, redirect
                    $this->addFlash('error', 'You tried to add the same lesson twice.');
                    return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
                }
                // if not, put the id in the array
                $lessons[] = $lessonId;
                // loop to check each id
            }

            foreach($programs as $program){
                $program->setSession($session);
                $entityManager->persist($program);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Lessons added successfully.');
            return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
        } else {
            // Affichez les erreurs de formulaire
            foreach ($formAddLessons->getErrors(true) as $error) {
                $this->addFlash('error', $error->getMessage());
            }
        }

        return $this->render('session/show.html.twig', [
            'session' => $session,
            'nonRegisteredStudents' => $nonRegisteredStudents,
            'nonScheduledLessons' => $nonScheduledLessons,
            'formAddLessons' => $formAddLessons,
            'searchResult' => $searchResult,
            'modalOpen' => $modalOpen,
        ]);
    }

}
