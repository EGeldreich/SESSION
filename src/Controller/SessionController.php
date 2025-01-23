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

    // #[Route('/session/{id}/addLessons', name: 'add_lessons')]
    // public function addLesson(int $sessionId, Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     // $lessons = $request->request->all('lessons', []);
    //     $session = $entityManager->getRepository(Session::class)->find($sessionId);

    //     if (!$session) {
    //         $this->addFlash('error', 'No session found for id.');
    //         return $this->redirectToRoute('app_session');
    //     }

    //     $form = $this->createForm(ProgramType::class, $session);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($session);
    //         $entityManager->flush();

    //         $this->addFlash('success', 'Lessons added successfully.');

    //         return $this->redirectToRoute('show_session', ['id' => $sessionId]);
    //     }

    //     return $this->render('session/add_lesson.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }

    #[Route('/session/{id}', name: 'show_session')]
    public function show(Session $session = null,
    SessionRepository $sr,
    Request $request,
    EntityManagerInterface $entityManager): Response
    {
        if(!$session){
            return $this->redirectToRoute('app_session');
        }

        $nonRegisteredStudents = $sr->findNonRegisteredStudents($session->getId());
        $nonScheduledLessons = $sr->findNonScheduledLessons($session->getId());

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

            $this->addFlash('success', 'Lesson added successfully.');
            return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
        }

        return $this->render('session/show.html.twig', [
            'session' => $session,
            'nonRegisteredStudents' => $nonRegisteredStudents,
            'nonScheduledLessons' => $nonScheduledLessons,
            'formAddLessons' => $formAddLessons->createView(),
        ]);
    }

}
