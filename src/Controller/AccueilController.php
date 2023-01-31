<?php
namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Service\BoutiqueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class AccueilController extends AbstractController
{
  public function index(
    BoutiqueService $boutiqueService,
    CategorieRepository $categorieRepository,
    ProduitRepository $produitRepository
  ) {
    return $this->render('accueil.html.twig', []);
  }
}
