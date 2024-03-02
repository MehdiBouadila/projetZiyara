<?php

namespace App\Controller;

use App\Entity\ReservationVisite;
use App\Form\ReservationVisiteType;
use App\Repository\ReservationVisiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

#[Route('/reservation/visite')]
class ReservationVisiteController extends AbstractController
{
    #[Route('/', name: 'app_reservation_visite_index', methods: ['GET'])]
    public function index(ReservationVisiteRepository $reservationVisiteRepository): Response
    {
        return $this->render('back/reservation_visite/index.html.twig', [
            'reservation_visites' => $reservationVisiteRepository->findAll(),
        ]);
    }

    #[Route('/newf', name: 'app_reservation_visite_new_front', methods: ['GET', 'POST'])]
    public function new_front(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservationVisite = new ReservationVisite();
        $form = $this->createForm(ReservationVisiteType::class, $reservationVisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservationVisite);
            $entityManager->flush();

            

            return $this->redirectToRoute('app_visite_index_f');
        }

        return $this->render('front/visite/newRes.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }
    #[Route('/mesres', name: 'mesres', methods: ['GET', 'POST'])]
    public function mesres(Request $request, EntityManagerInterface $entityManager): Response
    {
        

        return $this->render('front/visite/mesres.html.twig', );
    }

    #[Route('/new', name: 'app_reservation_visite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservationVisite = new ReservationVisite();
        $form = $this->createForm(ReservationVisiteType::class, $reservationVisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservationVisite);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_visite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/reservation_visite/new.html.twig', [
            'reservation_visite' => $reservationVisite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_visite_show', methods: ['GET'])]
    public function show(ReservationVisite $reservationVisite): Response
    {
        return $this->render('back/reservation_visite/show.html.twig', [
            'reservation_visite' => $reservationVisite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_visite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReservationVisite $reservationVisite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationVisiteType::class, $reservationVisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_visite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/reservation_visite/edit.html.twig', [
            'reservation_visite' => $reservationVisite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_visite_delete', methods: ['POST'])]
    public function delete(Request $request, ReservationVisite $reservationVisite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationVisite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservationVisite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_visite_index', [], Response::HTTP_SEE_OTHER);
    }


    
    #[Route('/load-events', name: 'fc_load_events', methods: ['POST'])]
    public function loadEvents(Request $request, LoggerInterface $logger): JsonResponse
    {
        $logger->info('loadEvents function is being called.');
        $entityManager = $this->getDoctrine()->getManager();
    
        
        $reservations = $entityManager->getRepository(ReservationVisite::class)->findAll();
    
        
        $events = [];
        foreach ($reservations as $reservation) {
            $events[] = [
                'title' => 'Reservation for ' . $reservation->getIdVisite()->getTitre(),
                'start' => $reservation->getDateReservationVisite()->format('Y-m-d'),
                'end' => $reservation->getDateReservationVisite()->format('Y-m-d'),
                
            ];
        }
    
        return $this->json($events);
    }

}


