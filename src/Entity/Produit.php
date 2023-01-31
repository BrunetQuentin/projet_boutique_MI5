<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $lebelle = null;

  #[ORM\Column(length: 255)]
  private ?string $visuel = null;

  #[ORM\Column(length: 255)]
  private ?string $texte = null;

  #[ORM\ManyToOne(inversedBy: 'products')]
  #[ORM\JoinColumn(nullable: false)]
  private ?Categorie $categorie = null;

  #[ORM\Column]
  private ?float $prix = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getLebelle(): ?string
  {
    return $this->lebelle;
  }

  public function setLebelle(string $lebelle): self
  {
    $this->lebelle = $lebelle;

    return $this;
  }

  public function getVisuel(): ?string
  {
    return $this->visuel;
  }

  public function setVisuel(string $visuel): self
  {
    $this->visuel = $visuel;

    return $this;
  }

  public function getTexte(): ?string
  {
    return $this->texte;
  }

  public function setTexte(string $texte): self
  {
    $this->texte = $texte;

    return $this;
  }

  public function getPrix(): ?string
  {
    return $this->prix;
  }

  public function setPrix(string $prix): self
  {
    $this->prix = $prix;

    return $this;
  }

  public function getCategorie(): ?string
  {
    return $this->categorie;
  }

  public function setCategorie(string $categorie): self
  {
    $this->categorie = $categorie;

    return $this;
  }
}
