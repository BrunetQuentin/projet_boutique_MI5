<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BoutiqueService;
class PanierController extends AbstractController
{
  public function index(BoutiqueService $boutique)
  {
    session_start();
    $panier = $_SESSION['panier'] ?? [];
    return $this->render('panier.html.twig', [
      'panier' => $panier,
      'total' => array_reduce(
        $panier,
        function ($total, $produit) {
          return $total + $produit->prix;
        },
        0
      ),
    ]);
  }

  public function add($produitId, BoutiqueService $boutique)
  {
    session_start();
    // On récupère le produit à ajouter au panier
    $produit = $boutique->findProduitById($produitId);
    // On récupère le panier en cours
    $panier = $_SESSION['panier'] ?? [];
    // Si le produit existe deja incrementer la valeur sinon créer l'objet avec la valeur 1
    if (array_key_exists($produitId, $panier)) {
      $panier[$produit->id]->quantite++;
    } else {
      $panier[$produit->id] = ['produit' => $produit, 'quantite' => 1];
    }
    $panier[] = $produit;
    // On sauvegarde le panier en session
    $_SESSION['panier'] = $panier;
    // On redirige vers la page précédente
    $request = $this->get('request_stack')->getCurrentRequest();
    return $this->redirect($request->headers->get('referer'));
  }

  public function remove($produitId)
  {
    session_start();

    // On récupère le panier en cours
    $panier = $_SESSION['panier'] ?? [];
    // On supprime le produit du panier
    $panier = array_filter($panier, function ($produit) use ($produitId) {
      return $produit->id != $produitId;
    });
    // On sauvegarde le panier en session
    $_SESSION['panier'] = $panier;
    // On redirige vers la page précédente
    $request = $this->get('request_stack')->getCurrentRequest();
    return $this->redirect($request->headers->get('referer'));
  }
}
