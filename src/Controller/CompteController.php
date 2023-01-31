<?php
namespace App\Controller;

use App\Service\CompteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompteController extends AbstractController
{
  public function connect()
  {
    return $this->render('compte/connexion.html.twig', []);
  }
  public function orders(CompteService $compte)
  {
    $compteId = $compte->getCompteId();

    // $boutique->getCommandeByCompteId($compteId);

    return $this->render('compte/mesCommandes.html.twig', []);
  }
  public function account()
  {
    return $this->render('compte/monCompte.html.twig', []);
  }
  public function deconnect()
  {
    return $this->render('compte/monCompte.html.twig', []);
  }
  public function login(CompteService $compteService)
  {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!isset($email) || !isset($password)) {
      return $this->redirectToRoute("compteConnexion");
    }

    $compte = $compteService->connect($email, $password);

    if (!isset($compte)) {
      return $this->redirectToRoute("compteConnexion");
    }
    return $this->redirectToRoute("boutique");
  }
}
