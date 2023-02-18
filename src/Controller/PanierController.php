<?php
namespace App\Controller;

use App\Entity\LigneCommande;
use App\Repository\CommandeRepository;
use App\Repository\LigneCommandeRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\PanierService;

class PanierController extends AbstractController
{
  public function index(PanierService $panier)
  {
    $contenu = $panier->getContenu();
    $total = $panier->getTotal();
    $nbProduits = $panier->getNbProduits();

    return $this->render('panier.html.twig', [
      'panier' => $contenu,
      'total' => $total,
      'nbProduits' => $nbProduits,
    ]);
  }

  public function add($produitId, PanierService $panier)
  {
    $panier->ajouterProduit($produitId);
    $request = $this->get('request_stack')->getCurrentRequest();
    return $this->redirect($request->headers->get('referer'));
  }

  public function remove($produitId, PanierService $panier)
  {
    $panier->enleverProduit($produitId);
    $request = $this->get('request_stack')->getCurrentRequest();
    return $this->redirect($request->headers->get('referer'));
  }

  public function delete($produitId, PanierService $panier)
  {
    $panier->supprimerProduit($produitId);
    $request = $this->get('request_stack')->getCurrentRequest();
    return $this->redirect($request->headers->get('referer'));
  }

  public function clear(PanierService $panier)
  {
    $panier->vider();
    $request = $this->get('request_stack')->getCurrentRequest();
    return $this->redirect($request->headers->get('referer'));
  }

  public function checkout(PanierService $panier, CommandeRepository $commandeRepository, LigneCommandeRepository $ligneCommandeRepository, ProduitRepository $produitRepository)
  {
    if($this->getUser()){

      $contenu = $panier->getContenu();

      $ligneCommandes = [];

      $commande = $commandeRepository->create($this->getUser());

      foreach ($contenu as $ligneCommande) {
        dump($ligneCommande['produit']);
        $ligneCommande = $ligneCommandeRepository->create($ligneCommande['produit'] , $ligneCommande['quantite'], $commande);

        $ligneCommandes[] = $ligneCommande;
        $commande->addLigneCommande($ligneCommande);
      }

      $commandeRepository->save($commande, true);

      $panier->vider();

      return $this->redirectToRoute('compteCommandes');
    } else {
      return $this->redirectToRoute('app_login');
    }
  }
}
