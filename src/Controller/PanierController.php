<?php
namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'app_panier')]
class PanierController extends AbstractController
{

    #[Route('/panier/index', name: 'app_panier_index')]
    public function index(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $panier = $session->get('panier', []);

        // On initialise des variables
        $data = [];
        $total = 0;
        

        foreach($panier as $id => $quantite){
            $produit = $produitRepository->find($id);

            $data[] = [
                'produit' => $produit,
                'quantite' => $quantite
            ];
            $total += $produit->getPrix() * $quantite;
        }
        
        return $this->render('commande/panier.html.twig', compact('data', 'total'));
    }

    #[Route('/add/{id}', name: 'app_panier_add')]
    public function addproduit(Produit $produit, SessionInterface $session)
    {
        //On récupère l'id du produit
        $id = $produit->getId();

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // On ajoute le produit dans le panier s'il n'y est pas encore
        // Sinon on incrémente sa quantité
        if(empty($panier[$id])){
            $panier[$id] = 1;
        }else{
            $panier[$id]++;
        }

        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('app_panier_index');
    }

}