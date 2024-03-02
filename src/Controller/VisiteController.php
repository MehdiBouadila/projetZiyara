<?php

namespace App\Controller;

use App\Entity\CategorieVisite;
use App\Entity\Favoris;
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
use Symfony\Component\HttpFoundation\JsonResponse;
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
    #[Route('/mesfav', name: 'mesfav', methods: ['GET'])]
    public function mesfav(EntityManagerInterface $entityManager): Response
    {
        $favoriteRepository = $entityManager->getRepository(Favoris::class);
    
        // Query to find all favorites
        $favorites = $favoriteRepository->findAll();
    
        // Extract visit IDs from the favorites
        $visitIds = [];
        foreach ($favorites as $favorite) {
            $visitIds[] = $favorite->getIdVisite()->getId();
        }
    
        // Query visits using the extracted visit IDs
        $visitRepository = $entityManager->getRepository(Visite::class);
        $visites = $visitRepository->findBy(['id' => $visitIds]);
    
        return $this->render('front/visite/mesfav.html.twig', [
            'visites' => $visites,
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

    #[Route('/s/{id}', name: 'app_show_visite_new_front', methods: ['GET'])]
    public function showf(Visite $visite): Response
    {
        return $this->render('front/visite/show.html.twig', [
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


    public function createFavorite(Request $request,EntityManagerInterface $entityManager,visiteRepository $visiteRepository)
    {
        // Retrieve visit ID from the request
        $visitId = $request->request->get('visitId');
    
        // Get the authenticated user (assuming you're using Symfony's security component)
        $user = $this->getUser();
    
        // Create the new favorite instance
        $favorite = new Favoris();
        $favorite->setIdUser($user);
        
        // Set the visit using Doctrine relationship
        $visit = $entityManager->getRepository(Visite::class)->find($visitId);
        $favorite->setIdVisite($visit);
        $favorite = $this->getDoctrine()->getRepository(Favoris::class)->findOneBy([
            'idVisite' => $visitId,
        
        ]);
    
        if ($favorite) {
            // If favorite exists, delete it
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($favorite);
            $entityManager->flush();
        } else {
            // If favorite doesn't exist, create it
            $favorite = new Favoris();
            $favorite->setIdVisite($visit);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($favorite);
            $entityManager->flush();
        }
        return $this->render('front/visite/index.html.twig', [
            'visites' => $visiteRepository->findAll(),
        ]);
    }

    public function removeFavorite(Request $request,EntityManagerInterface $entityManager,visiteRepository $visiteRepository)
    {
        // Retrieve visit ID from the request
        $visitId = $request->request->get('visitId');
    
        // Get the authenticated user (assuming you're using Symfony's security component)
        $user = $this->getUser();
    
        // Create the new favorite instance
        $favorite = new Favoris();
        $favorite->setIdUser($user);
        
        // Set the visit using Doctrine relationship
        $visit = $entityManager->getRepository(Visite::class)->find($visitId);
        $favorite->setIdVisite($visit);
        $favorite = $this->getDoctrine()->getRepository(Favoris::class)->findOneBy([
            'idVisite' => $visitId,
        
        ]);
    
        if ($favorite) {
            // If favorite exists, delete it
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($favorite);
            $entityManager->flush();
        } else {
            // If favorite doesn't exist, create it
            $favorite = new Favoris();
            $favorite->setIdVisite($visit);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($favorite);
            $entityManager->flush();
        }
        $favoriteRepository = $entityManager->getRepository(Favoris::class);
    
        // Query to find all favorites
        $favorites = $favoriteRepository->findAll();
    
        // Extract visit IDs from the favorites
        $visitIds = [];
        foreach ($favorites as $favorite) {
            $visitIds[] = $favorite->getIdVisite()->getId();
        }
    
        // Query visits using the extracted visit IDs
        $visitRepository = $entityManager->getRepository(Visite::class);
        $visites = $visitRepository->findBy(['id' => $visitIds]);
    
        return $this->render('front/visite/mesfav.html.twig', [
            'visites' => $visites,
        ]);
    }
}


