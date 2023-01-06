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
}
