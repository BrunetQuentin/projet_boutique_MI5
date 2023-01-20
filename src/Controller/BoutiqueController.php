<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BoutiqueService;
class BoutiqueController extends AbstractController
{
  public function index(BoutiqueService $boutique)
  {
    return $this->render('boutique.html.twig', [
      'categories' => $boutique->findAllCategories(),
    ]);
  }

  public function find(BoutiqueService $boutique, $produitName)
  {
    $produits = $boutique->findProduitsByLibelleOrTexte($produitName);

    return $this->render('recherche.html.twig', [
      "recherche" => $produitName,
      'produits' => $produits,
    ]);
  }
}
