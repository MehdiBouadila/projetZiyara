<?php

namespace App\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Guide;
use App\Form\GuideType;
use App\Repository\GuideRepository; // Ajoutez cette ligne pour importer le trait
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class GuideController extends AbstractController
{
    #[Route('/guide', name: 'app_guide')]
    public function index(): Response
    {
        return $this->render('guide/index.html.twig', [
            'controller_name' => 'GuideController',
        ]);
    }

    #[Route('/add_guide', name: 'add_guide')]
    public function addGuide(EntityManagerInterface $em, Request $request): Response
    {
        $guide = new Guide();
        $form = $this->createForm(GuideType::class, $guide);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form['imageFile']->getData();
    
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Sanitize the filename (remove unwanted characters)
                $safeFilename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
    
                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'), // Replace with your actual path
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle file upload error
                    $this->addFlash('error', 'Une erreur s\'est produite lors du téléchargement de l\'image.');
                    return $this->redirectToRoute('add_guide'); // Redirect to the form page
                }
    
                // Set the image filename in the Guide entity
                $guide->setImageGuide($newFilename);
            }
    
            $em->persist($guide);
            $em->flush();
    
            $this->addFlash('success', 'Guide ajoutée avec succès!');
    
            return $this->redirectToRoute('ListGuide');
        }
    
        return $this->render('guide/add.html.twig', [
            'formA' => $form->createView(),
        ]);
    }


   #[Route('/ListGuide', name: 'ListGuide')]
   public function ListBook(GuideRepository $repo): Response
   {
       $guides = $repo->findAll();
       return $this->render('guide/listGuide.html.twig', [
           'guides' => $guides,
            ]);

   }

   #[Route('/listeFront', name: 'listeFront')]
   public function ListBook2(GuideRepository $repo): Response
   {
       $guides = $repo->findAll();
       return $this->render('guide/listeFront.html.twig', [
           'guides' => $guides,
            ]);

   }
   #[Route('/detailsGuide/{id}', name: 'detailsGuide')]
    public function showDetails(int $id, GuideRepository $repo): Response
    {
        $guide = $repo->find($id);

        if (!$guide) {
            throw $this->createNotFoundException(
                'No guide found for id '.$id
            );
        }

        return $this->render('guide/detailsGuide.html.twig', [
            'guide' => $guide,
        ]);
    }


   

#[Route('/edit_guide/{id}', name: 'edit_guide', methods: ['GET', 'POST'])]
public function edit(Request $request, GuideRepository $repository, int $id): Response
{
    $guide = $repository->findOneBy(["id" => $id]);
    $form = $this->createForm(GuideType::class, $guide);
   
    $form->handleRequest($request);
   
    if ($form->isSubmitted() && $form->isValid()) {
        // Handle image file upload
        $imageFile = $form['imageFile']->getData();
        if ($imageFile) {
            // Generate a unique filename for the image
            $newFilename = uniqid().'.'.$imageFile->guessExtension();
            // Move the file to the directory where images are stored
            try {
                $imageFile->move(
                    $this->getParameter('image_directory'), // Replace with your actual path
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle file upload error
                // Optionally, add a flash message and redirect
                // You can modify this part according to your needs
            }
            // Update the image filename in the Guide entity
            $guide->setImageGuide($newFilename);
        }
        
        // Flush changes to the database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $this->addFlash('success', 'Guide modifiée avec succès!');

        return $this->redirectToRoute('ListGuide');
    }
   
    return $this->render('guide/editGuide.html.twig', [
        'form' => $form->createView(),
    ]);
}



   #[Route('/delete_guide/{id}', name: 'delete_guide', methods: ['POST'])]
public function delete(EntityManagerInterface $manager, int $id): Response
{
    $repository = $this->getDoctrine()->getRepository(Guide::class);
    $guide = $repository->find($id);

    if (!$guide) {
        $this->addFlash('error', 'L\'auteur n\'existe pas !');
        return $this->redirectToRoute('guides'); // Assurez-vous que la route est correcte
    }

    $manager->remove($guide);
    $manager->flush();

    $this->addFlash('success', 'Suppression réussie !');

    return $this->redirectToRoute('ListGuide'); // Assurez-vous que la route est correcte
}

}
