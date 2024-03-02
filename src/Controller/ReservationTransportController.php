<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Transport;
use App\Entity\ReservationTransport;
use App\Form\ReservationTransportType;
use App\Repository\ReservationTransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation/transport')]
class ReservationTransportController extends AbstractController
{
    #[Route('/', name: 'app_reservation_transport_index', methods: ['GET'])]
    public function index(ReservationTransportRepository $reservationTransportRepository): Response
    {
        $reservationTransports = $reservationTransportRepository->findAll();

        return $this->render('back/reservation_transport/index.html.twig', [
            'reservation_transports' => $reservationTransports,
        ]);
    }

    #[Route('/rf', name: 'app_reservation_transport_index_front', methods: ['GET'])]
    public function indexfr(ReservationTransportRepository $reservationTransportRepository): Response
    {
        $reservationTransports = $reservationTransportRepository->findAll();

        return $this->render('front/transport/indext.html.twig', [
            'reservation_transports' => $reservationTransports,
            'transports' => $reservationTransports,
        ]);
    }

    #[Route('/new', name: 'app_reservation_transport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservationTransport = new ReservationTransport();
        $form = $this->createForm(ReservationTransportType::class, $reservationTransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservationTransport);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_transport_index');
        }

        return $this->render('back/reservation_transport/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/newf', name: 'app_reservation_transport_new_front', methods: ['GET', 'POST'])]
    public function new_front(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $reservationTransport = new ReservationTransport();
        $form = $this->createForm(ReservationTransportType::class, $reservationTransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservationTransport);
            $entityManager->flush();

            /*$this->addFlash('success', 'Reservation added successfully!');*/

            return $this->redirectToRoute('send_home');
        }

        return $this->render('front/transport/newRes.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_transport_show', methods: ['GET'])]
    public function show(ReservationTransport $reservationTransport): Response
    {
        return $this->render('back/reservation_transport/show.html.twig', [
            'reservation_transport' => $reservationTransport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_transport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReservationTransport $reservationTransport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationTransportType::class, $reservationTransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_transport_index');
        }

        return $this->render('back/reservation_transport/edit.html.twig', [
            'reservation_transport' => $reservationTransport,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_transport_delete', methods: ['POST'])]
    public function delete(Request $request, ReservationTransport $reservationTransport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationTransport->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservationTransport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_transport_index');
    }
}
