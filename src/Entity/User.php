<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', message: "L'email que vous avez indiqué est déjà utilisé.")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas un email valide."
     * )
     * @Assert\NotBlank(
     *    message = "L'email ne peut pas être vide."
     * )
     * @Assert\Length(
     *     min = 5,
     *    max = 180,
     *    minMessage = "L'email doit faire au moins {{ limit }} caractères.",
     *   maxMessage = "L'email ne peut pas être plus long que {{ limit }} caractères."
     * )
     */
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type:"array")]
    private array $roles = [];

    /**
     * @Assert\NotBlank(
     *   message = "Le mot de passe ne peut pas être vide."
     * )
     * @Assert\Length(
     *    min = 8,
     *   max = 255,
     *  minMessage = "Le mot de passe doit faire au moins {{ limit }} caractères.",
     * maxMessage = "Le mot de passe ne peut pas être plus long que {{ limit }} caractères."
     * )
     * @Assert\Regex(
     *    pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
     *  message="Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial."
     * )
     * @Assert\NotCompromisedPassword(
     *   message="Le mot de passe ne doit pas être compromis."
     * )
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @Assert\NotBlank(
     *  message = "Le nom ne peut pas être vide."
     * )
     * @Assert\Length(
     *   min = 2,
     * max = 255,
     * minMessage = "Le nom doit faire au moins {{ limit }} caractères.",
     * maxMessage = "Le nom ne peut pas être plus long que {{ limit }} caractères."
     * )
     * @Assert\Regex(
     *  pattern="/^[a-zA-ZÀ-ÿ]+$/",
     * message="Le nom ne peut contenir que des lettres."
     * )
     */
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @Assert\NotBlank(
     * message = "Le prénom ne peut pas être vide."
     * )
     * @Assert\Length(
     * min = 2,
     * max = 255,
     * minMessage = "Le prénom doit faire au moins {{ limit }} caractères.",
     * maxMessage = "Le prénom ne peut pas être plus long que {{ limit }} caractères."
     * )
     * @Assert\Regex(
     * pattern="/^[a-zA-ZÀ-ÿ]+$/",
     * message="Le prénom ne peut contenir que des lettres."
     * )
     */
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commande::class)]
    private Collection $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return $roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }
}
