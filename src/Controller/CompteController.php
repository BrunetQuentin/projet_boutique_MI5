<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;

class CompteController extends AbstractController
{
  public function orders()
  {
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

  // public function login(CompteService $compteService)
  // {
  //   $email = $_POST["email"];
  //   $password = $_POST["password"];

  //   if (!isset($email) || !isset($password)) {
  //     return $this->redirectToRoute("compteConnexion");
  //   }

  //   $compte = $compteService->connect($email, $password);

  //   if (!isset($compte)) {
  //     return $this->redirectToRoute("compteConnexion");
  //   }
  //   return $this->redirectToRoute("boutique");
  // }

  public function connect(AuthenticationUtils $authenticationUtils): Response
  {
    if ($this->getUser()) {
      return $this->redirectToRoute('boutique');
    }

    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();
    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('compte/connexion.html.twig', [
      'last_username' => $lastUsername,
      'error' => $error,
    ]);
  }
}
