<?php

namespace App\Controller;

use App\Entity\CategorieTransport;
use App\Form\CategorieTransportType;
use App\Repository\CategorieTransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorietransport')]
class CategorieTransportController extends AbstractController
{
    #[Route('/', name: 'app_categorie_transport_index', methods: ['GET'])]
    public function index(CategorieTransportRepository $categorieTransportRepository): Response
    {
        return $this->render('back/categorie_transport/index.html.twig', [
            'categorie_transports' => $categorieTransportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categorie_transport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieTransport = new CategorieTransport();
        $form = $this->createForm(CategorieTransportType::class, $categorieTransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorieTransport);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/categorie_transport/new.html.twig', [
            'categorie_transport' => $categorieTransport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_transport_show', methods: ['GET'])]
    public function show(CategorieTransport $categorieTransport): Response
    {
        return $this->render('back/categorie_transport/show.html.twig', [
            'categorie_transport' => $categorieTransport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_transport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieTransport $categorieTransport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieTransportType::class, $categorieTransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/categorie_transport/edit.html.twig', [
            'categorie_transport' => $categorieTransport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_transport_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieTransport $categorieTransport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieTransport->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorieTransport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_transport_index', [], Response::HTTP_SEE_OTHER);
    }
}
