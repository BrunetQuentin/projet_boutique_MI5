<?php

// src/Service/PanierService.php
namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\BoutiqueService;

// Service pour manipuler le panier et le stocker en session
class CompteService
{
  private $compte;

  private $session; // Service session
  private $userRepository;

  public function __construct(
    SessionInterface $session,
    UserRepository $userRepository
  ) {
    // Récupération des services session
    $this->session = $session;
    $this->$userRepository = $userRepository;

    // recupération de laconnexion en session
    $this->compte = $this->session->get('connect', null);
  }

  public function getCompte()
  {
    return $this->compte;
  }

  public function connect($email, $password)
  {
    $user = $this->userRepository->findUserByEmail($email);

    if ($user === null) {
      return -1;
    }

    if ($user->getPassword() !== $password) {
      return 0;
    }

    $this->compte = $user;
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
}
