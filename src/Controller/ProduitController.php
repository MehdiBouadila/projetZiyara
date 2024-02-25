<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }
    #[Route('/produit/listfront', name: 'app_produit_indexfront', methods: ['GET'])]
    public function indexfront(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/indexfront.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }
    

    #[Route('/new/{id}', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger,CategorieRepository $repo): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

         $idFromUrl = $request->query->get('id');
         $categorie=$repo->find($idFromUrl);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $produit->setCatt($categorie);
            /** @var UploadedFile $imageFile */
                $imageFile = $form->get('image')->getData();

        if ($imageFile) {
             $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
             $safeFilename = $slugger->slug($originalFilename);
             $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            // Move the file to the directory where your images are stored
            try {
                $imageFile->move($this->getParameter('img_directory'), // specify the directory where images should be stored
                    $newFilename
                );
             } catch (FileException $e) {
         // Handle the exception if something happens during the file upload
            }

     // Update the 'image' property to store the file name instead of its contents
                $produit->setImage($newFilename);
        }



            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }
    #[Route('produit/showfront/{id}', name: 'app_produitfront_show', methods: ['GET'])]
    public function showfront(Produit $produit): Response
    {
        return $this->render('produit/showfront.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
