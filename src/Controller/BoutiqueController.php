<?php
namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class BoutiqueController extends AbstractController
{
  public function index(CategorieRepository $categorieRepository)
  {

    dump($this->getUser());

    return $this->render('boutique.html.twig', [
      'categories' => $categorieRepository->findCategories(),
    ]);
  }

  public function find(ProduitRepository $produitRepository, $produitName)
  {
    $produits = $produitRepository->findProduitsByLibelleOrTexte($produitName);

    return $this->render('recherche.html.twig', [
      "recherche" => $produitName,
      'produits' => $produits,
    ]);
  }
}
