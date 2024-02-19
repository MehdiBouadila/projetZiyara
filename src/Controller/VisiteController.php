<?php

namespace App\Controller;

use App\Entity\CategorieVisite;
use App\Entity\Visite;
use App\Form\VisiteType;
use App\Repository\VisiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/visite')]
class VisiteController extends AbstractController
{
    #[Route('/', name: 'app_visite_index', methods: ['GET'])]
    public function index(VisiteRepository $visiteRepository): Response
    {
        return $this->render('back/visite/index.html.twig', [
            'visites' => $visiteRepository->findAll(),
        ]);
    }
    #[Route('/f', name: 'app_visite_index_f', methods: ['GET'])]
    public function indexf(visiteRepository $visiteRepository): Response
    {
        return $this->render('front/visite/index.html.twig', [
            'visites' => $visiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_visite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $visite = new Visite();
        
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);
        
        $categories = $this->getDoctrine()->getRepository(CategorieVisite::class)->findAll();

        
    

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imagev')->getData();
            if ($file) {
                $fileName = uniqid().'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('images_directory'), 
                    $fileName
                );
                $visite->setImagev($fileName);
            }
            $entityManager->persist($visite);
            $entityManager->flush();

            return $this->redirectToRoute('app_visite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/visite/new.html.twig', [
            'categories' => $categories,
            'visite' => $visite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_visite_show', methods: ['GET'])]
    public function show(Visite $visite): Response
    {
        return $this->render('back/visite/show.html.twig', [
            'visite' => $visite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_visite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Visite $visite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_visite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/visite/edit.html.twig', [
            'visite' => $visite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_visite_delete', methods: ['POST'])]
    public function delete(Request $request, Visite $visite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$visite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($visite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_visite_index', [], Response::HTTP_SEE_OTHER);
    }
}
