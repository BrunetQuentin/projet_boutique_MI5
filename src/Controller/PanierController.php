<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\PanierService;
use App\Service\CompteService;

class PanierController extends AbstractController
{
  public function index(PanierService $panier)
  {
    return $this->render('panier.html.twig', [
      'panier' => $panier->getContenu(),
      'total' => $panier->getTotal(),
      'nbProduits' => $panier->getNbProduits(),
    ]);
  }

  public function add($produitId, PanierService $panier)
  {
    $panier->ajouterProduit($produitId);
    $request = $this->get('request_stack')->getCurrentRequest();
    return $this->redirect($request->headers->get('referer'));
  }

  public function remove($produitId, PanierService $panier)
  {
    $panier->enleverProduit($produitId);
    $request = $this->get('request_stack')->getCurrentRequest();
    return $this->redirect($request->headers->get('referer'));
  }

  public function delete($produitId, PanierService $panier)
  {
    $panier->supprimerProduit($produitId);
    $request = $this->get('request_stack')->getCurrentRequest();
    return $this->redirect($request->headers->get('referer'));
  }

  public function clear(PanierService $panier)
  {
    $panier->vider();
    $request = $this->get('request_stack')->getCurrentRequest();
    return $this->redirect($request->headers->get('referer'));
  }

  public function checkout(PanierService $panier, CompteService $compte)
  {
    if ($compte->getCompte() == null) {
      return $this->redirectToRoute('compteConnexion');
    } else {
      $panier->checkout();
      return $this->redirectToRoute('compteCommandes');
    }
  }
}
