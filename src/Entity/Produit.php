<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $visuel = null;

  #[ORM\Column(length: 255)]
  private ?string $texte = null;

  #[ORM\ManyToOne(inversedBy: 'products')]
  #[ORM\JoinColumn(nullable: false)]
  private ?Categorie $categorie = null;

  #[ORM\Column]
  private ?float $prix = null;

  #[ORM\Column(length: 255)]
  private ?string $libelle = null;

  #[ORM\OneToMany(mappedBy: 'article', targetEntity: LigneCommande::class)]
  private Collection $ligneCommandes;

  public function __construct()
  {
    $this->ligneCommandes = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
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

  public function getCategorie(): ?Categorie
  {
    return $this->categorie;
  }

  public function setCategorie(string $categorie): self
  {
    $this->categorie = $categorie;

    return $this;
  }

  public function setLibelle(string $libelle): self
  {
    $this->libelle = $libelle;

    return $this;
  }

  public function getLibelle(): ?string
  {
    return $this->libelle;
  }

  /**
   * @return Collection<int, LigneCommande>
   */
  public function getLigneCommandes(): Collection
  {
    return $this->ligneCommandes;
  }

  public function addLigneCommande(LigneCommande $ligneCommande): self
  {
    if (!$this->ligneCommandes->contains($ligneCommande)) {
      $this->ligneCommandes->add($ligneCommande);
      $ligneCommande->setArticle($this);
    }

    return $this;
  }

  public function removeLigneCommande(LigneCommande $ligneCommande): self
  {
    if ($this->ligneCommandes->removeElement($ligneCommande)) {
      // set the owning side to null (unless already changed)
      if ($ligneCommande->getArticle() === $this) {
        $ligneCommande->setArticle(null);
      }
    }

    return $this;
  }
}
