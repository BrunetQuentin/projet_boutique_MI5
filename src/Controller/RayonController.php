<?php
namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Error;
use Symfony\Component\HttpFoundation\Response;
class RayonController extends AbstractController
{
  public function index(
    $rayonId,
    CategorieRepository $categorieRepository,
    ProduitRepository $produitRepository
  ): Response {
    // bring the category and the products of the category

    $category = $categorieRepository->findCategorieById($rayonId);
    if (!$category) {
      throw new Error('Category not found');
    }

    $produits = $produitRepository->findProduitsByCategorie($rayonId);

    dump($produits);

    return $this->render('rayon.html.twig', [
      'category' => $category,
      'produits' => $produits,
    ]);
  }
}
