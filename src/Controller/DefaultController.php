<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BoutiqueService;
use App\Service\PanierService;

class DefaultController extends AbstractController
{
  public function index()
  {
    return $this->render('base.html.twig', []);
  }

  public function navigation(PanierService $panier)
  {
    return $this->render('navBar.html.twig', [
      "nbrProduits" => $panier->getNbProduits(),
    ]);
  }

  public function bestSeller(BoutiqueService $boutique)
  {
    $bestSellers = $boutique->getBestSeller();

    $produits = [];

    foreach ($bestSellers as $key => $value) {
      $produit = $boutique->findProduitById($key);
      // if this is a valide product
      if ($produit) {
        $produits[$key] = $produit;
      } else {
        unset($bestSellers[$key]);
      }
    }

    return $this->render('bestSeller.html.twig', [
      "bestSellers" => $bestSellers,
      "produits" => $produits,
    ]);
  }
}
