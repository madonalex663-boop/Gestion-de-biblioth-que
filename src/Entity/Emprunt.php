<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Veuillez sélectionner un livre.")]
    private ?Livre $livre = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "Le nom de l'emprunteur est obligatoire.")]
    private ?string $emprunteur = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull(message: "La date d'emprunt est obligatoire.")]
    private ?\DateTimeInterface $dateEmprunt = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull(message: "La date de retour prévue est obligatoire.")]
    #[Assert\GreaterThan(propertyPath: "dateEmprunt", message: "La date de retour prévue doit être après la date d'emprunt.")]
    private ?\DateTimeInterface $dateRetourPrevue = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateRetourEffective = null;

    #[ORM\Column]
    private bool $rendu = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): static
    {
        $this->livre = $livre;
        return $this;
    }

    public function getEmprunteur(): ?string
    {
        return $this->emprunteur;
    }

    public function setEmprunteur(string $emprunteur): static
    {
        $this->emprunteur = $emprunteur;
        return $this;
    }

    public function getDateEmprunt(): ?\DateTimeInterface
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(\DateTimeInterface $dateEmprunt): static
    {
        $this->dateEmprunt = $dateEmprunt;
        return $this;
    }

    public function getDateRetourPrevue(): ?\DateTimeInterface
    {
        return $this->dateRetourPrevue;
    }

    public function setDateRetourPrevue(\DateTimeInterface $dateRetourPrevue): static
    {
        $this->dateRetourPrevue = $dateRetourPrevue;
        return $this;
    }

    public function getDateRetourEffective(): ?\DateTimeInterface
    {
        return $this->dateRetourEffective;
    }

    public function setDateRetourEffective(?\DateTimeInterface $dateRetourEffective): static
    {
        $this->dateRetourEffective = $dateRetourEffective;
        return $this;
    }

    public function isRendu(): bool
    {
        return $this->rendu;
    }

    public function setRendu(bool $rendu): static
    {
        $this->rendu = $rendu;
        return $this;
    }
}
