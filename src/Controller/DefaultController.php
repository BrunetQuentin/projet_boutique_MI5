<?php
namespace App\Controller;

use App\Repository\LigneCommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

  public function bestSeller(LigneCommandeRepository $ligneCommandeRepository)
  {
    $bestSellers = $ligneCommandeRepository->findBestSeller(4);

    return $this->render('bestSeller.html.twig', [
      "bestSellers" => $bestSellers,
    ]);
  }
}
