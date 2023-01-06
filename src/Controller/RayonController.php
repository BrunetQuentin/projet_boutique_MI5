<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BoutiqueService;
class RayonController extends AbstractController
{
  public function index($rayonId, BoutiqueService $boutique)
  {
    return $this->render('rayon.html.twig', [
      'category' => $boutique->findCategorieById($rayonId),
      'produits' => $boutique->findProduitsByCategorie($rayonId),
    ]);
  }
}
