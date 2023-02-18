<?php

// src/Service/PanierService.php
namespace App\Service;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\BoutiqueService;

// Service pour manipuler le panier et le stocker en session
class PanierService
{
  ////////////////////////////////////////////////////////////////////////////
  const PANIER_SESSION = 'panier'; // Le nom de la variable de session du panier
  private $session; // Le service Session
  private $compte;
  private $panier; // Tableau associatif idProduit => quantite
  ////////////////////////////////////////////////////////////////////////////
  private $categorieRepository;
  private $produitRepository;

  //  donc $this->panier[$i] = quantite du produit dont l'id est $i
  // constructeur du service
  public function __construct(
    SessionInterface $session,
    CategorieRepository $categorieRepository,
    ProduitRepository $produitRepository
  ) {
    // Récupération des services session et BoutiqueService
    $this->session = $session;
    // Récupération du panier en session s'il existe, init. à vide sinon
    $this->panier = $session->get($this::PANIER_SESSION, []); // initialisation du Panier : à compléter
    $this->categorieRepository = $categorieRepository;
    $this->produitRepository = $produitRepository;
  }
  // getContenu renvoie le contenu du panier
  //  tableau d'éléments [ "produit" => un produit, "quantite" => quantite ]
  public function getContenu()
  {
    return array_map(function ($produitId) {
      return [
        "produit" => $this->produitRepository->findProduitById($produitId),
        "quantite" => $this->panier[$produitId],
      ];
    }, array_keys($this->panier));
  }
  // getTotal renvoie le montant total du panier
  public function getTotal()
  {
    $total = 0;
    foreach ($this->panier as $idProduit => $quantite) {
      $total +=
        $this->produitRepository->findProduitById($idProduit)->getPrix() *
        $quantite;
    }
    return $total;
  }
  // getNbProduits renvoie le nombre de produits dans le panier
  public function getNbProduits()
  {
    return array_reduce(
      $this->panier,
      function ($total, $quantite) {
        return $total + $quantite;
      },
      0
    );
  }
  // ajouterProduit ajoute au panier le produit $idProduit en quantite $quantite
  public function ajouterProduit(int $idProduit, int $quantite = 1)
  {
    if (!array_key_exists($idProduit, $this->panier)) {
      $this->panier[$idProduit] = 1;
    } else {
      $this->panier[$idProduit] += $quantite;
    }

    $this->session->set($this::PANIER_SESSION, $this->panier);
  }
  // enleverProduit enlève du panier le produit $idProduit en quantite $quantite
  public function enleverProduit(int $idProduit, int $quantite = 1)
  {
    if (array_key_exists($idProduit, $this->panier)) {
      $this->panier[$idProduit] -= $quantite;
      if ($this->panier[$idProduit] <= 0) {
        unset($this->panier[$idProduit]);
      }
    }

    $this->session->set($this::PANIER_SESSION, $this->panier);
  }
  // supprimerProduit supprime complètement le produit $idProduit du panier
  public function supprimerProduit(int $idProduit)
  {
    if (array_key_exists($idProduit, $this->panier)) {
      unset($this->panier[$idProduit]);
    }

    $this->session->set($this::PANIER_SESSION, $this->panier);
  }
  // vider vide complètement le panier
  public function vider()
  {
    $this->panier = [];
    $this->session->set($this::PANIER_SESSION, $this->panier);
  }

  public function checkout()
  {
    if (!empty($this->panier)) {
      $validatePanier = [];

      // loop throught panier, get key and value, construct object with id and quantite
      foreach ($this->panier as $id => $quantite) {
        $validatePanier[] = [
          "id" => $id,
          "quantite" => $quantite,
        ];
      }

      // a faire
      // $this->boutique->addCommande(
      //   $validatePanier,
      //   $this->compte->getCompteId()
      // );

      $this->vider();
    }
  }
}
