<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class CompteController extends AbstractController
{
  public function connect()
  {
    return $this->render('compte/connexion.html.twig', []);
  }
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
}
