<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Produit;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProduitRepository;
use App\Form\ProduitType;


#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }


#[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
public function new( Request $request, SessionInterface $session, EntityManagerInterface $entityManager, ProduitRepository $produitRepository): Response
{
    // Create a new Commande entity
    $commande = new Commande();
    
    // Assuming Commande entity properties are set accordingly, adjust this part as needed
    $commande->setDate(new \DateTime()); // Set the date to the current date/time
    $commande->setStatut('En attente');
   
    $totalc = $request->query->get('total');
    $commande->setTotal((float)$totalc);
 // Set the default payment type
    
    // Fetch products from the database based on the IDs in the session (if applicable)
    // Example:
    $panier = $session->get('panier', []);
     foreach($panier as $itemId => $quantite) {
       $produit = $produitRepository->find($itemId);
         if($produit) {
            $commande->addPanier($produit);
       }
    }
    
    // Create the form for the Commande entity
    $form = $this->createForm(CommandeType::class, $commande);
    $form->handleRequest($request);

    // Handle form submission
    if ($form->isSubmitted() && $form->isValid()) {
        // Persist the Commande entity
        $entityManager->persist($commande);
        $entityManager->flush();

        // Redirect to the index page or another appropriate route
        return $this->redirectToRoute('app_produit_indexfront');
    }

    // Render the form template
    return $this->render('commande/new.html.twig', [
        'commande' => $commande,
        'form' => $form->createView(),
    ]);
}


        

    #[Route('/{id}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }

  

}
