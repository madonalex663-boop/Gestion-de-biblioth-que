<?php
namespace App\Entity;
use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $titre = null;
    #[ORM\Column(length: 20, unique: true, nullable: true)]
    #[Assert\Isbn(message: "L'ISBN n'est pas valide.")]
    private ?string $isbn = null;
    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateEdition = null;
    #[ORM\Column]
    private bool $disponible = true;
    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Veuillez sélectionner un auteur.")]
    private ?Auteur $auteur = null;
    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Veuillez sélectionner une catégorie.")]
    private ?Categorie $categorie = null;
    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Emprunt::class, orphanRemoval: true)]
    private Collection $emprunts;
    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitre(): ?string
    {
        return $this->titre;
    }
    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }
    public function setIsbn(?string $isbn): static
    {
        $this->isbn = $isbn;
        return $this;
    }
    public function getDateEdition(): ?\DateTimeInterface
    {
        return $this->dateEdition;
    }
    public function setDateEdition(?\DateTimeInterface $dateEdition): static
    {
        $this->dateEdition = $dateEdition;
        return $this;
    }
    public function isDisponible(): bool
    {
        return $this->disponible;
    }
    public function setDisponible(bool $disponible): static
    {
        $this->disponible = $disponible;
        return $this;
    }
    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }
    public function setAuteur(?Auteur $auteur): static
    {
        $this->auteur = $auteur;
        return $this;
    }
    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }
    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;
        return $this;
    }
    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function __toString(): string
    {
        return $this->titre ?? '';
    }
}
