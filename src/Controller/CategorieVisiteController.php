<?php

namespace App\Controller;

use App\Entity\CategorieVisite;
use App\Form\CategorieVisiteType;
use App\Repository\CategorieVisiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie/visite')]
class CategorieVisiteController extends AbstractController
{
    #[Route('/', name: 'app_categorie_visite_index', methods: ['GET'])]
    public function index(CategorieVisiteRepository $categorieVisiteRepository): Response
    {
        return $this->render('back/categorie_visite/index.html.twig', [
            'categorie_visites' => $categorieVisiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categorie_visite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieVisite = new CategorieVisite();
        $form = $this->createForm(CategorieVisiteType::class, $categorieVisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorieVisite);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_visite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/categorie_visite/new.html.twig', [
            'categorie_visite' => $categorieVisite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_visite_show', methods: ['GET'])]
    public function show(CategorieVisite $categorieVisite): Response
    {
        return $this->render('back/categorie_visite/show.html.twig', [
            'categorie_visite' => $categorieVisite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_visite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieVisite $categorieVisite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieVisiteType::class, $categorieVisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_visite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/categorie_visite/edit.html.twig', [
            'categorie_visite' => $categorieVisite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_visite_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieVisite $categorieVisite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieVisite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorieVisite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_visite_index', [], Response::HTTP_SEE_OTHER);
    }
}
