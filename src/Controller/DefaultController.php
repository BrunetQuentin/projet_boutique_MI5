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
    // TODO: Récupérer les 3 meilleurs vendeurs
    return $this->render('bestSeller.html.twig', [
      "produits" => $boutique->getBestSeller(),
    ]);
  }
}
