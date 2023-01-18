<?php

// src/Service/PanierService.php
namespace App\Service;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\BoutiqueService;

// Service pour manipuler le panier et le stocker en session
class CompteService
{
  private $comptes;
  private $compte;

  private $session; // Service session
  private $boutique; // Service BoutiqueService

  public function __construct(
    SessionInterface $session,
    BoutiqueService $boutique
  ) {
    // Récupération des services session et BoutiqueService
    $this->boutique = $boutique;
    $this->session = $session;

    $this->comptes = json_decode($this->comptesJson, true);

    // recupération de laconnexion en session
    $this->compte = $this->session->get('connect', null);
  }

  public function getCompte()
  {
    return $this->compte;
  }

  public function connect($email, $password)
  {
    $connected = null;
    foreach ($this->comptes as $compte) {
      print_r($compte);
      if ($compte['mail'] == $email && $compte['mdp'] == $password) {
        $connected = $compte;
        break;
      }
    }
    $this->compte = $connected;
    $this->session->set('connect', $this->compte);
    return $this->compte;
  }

  public function disconnect()
  {
    $this->session->remove('connect');
  }

  public function isConnect()
  {
    return $this->compte != null;
  }

  public function isRole($role)
  {
    return $this->compte['role'] == $role;
  }

  public function getCompteId()
  {
    return $this->compte['id'];
  }

  // create an array of fake compte with fake data
  private $comptesJson = <<<JSON
    [
        {
            "id" : 1,
            "mail": "admin@admin.com",
            "mdp": "admin",
            "nom": "admin",
            "prenom": "admin",
            "adresse": "admin",
            "role": "ROLE_ADMIN"
        },
        {
            "id" : 2,
            "mail": "acheteur@acheteur.com",
            "mdp": "acheteur",
            "nom": "acheteur",
            "prenom": "acheteur",
            "adresse": "acheteur",
            "role": "ROLE_USER"
        },
        {
            "id" : 3,
            "mail": "vendeur@vendeur.com",
            "mdp": "vendeur",
            "nom": "vendeur",
            "prenom": "vendeur",
            "adresse": "vendeur",
            "role": "ROLE_SELLER"
        }
    ]
JSON;
}
