<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
#[ORM\Table(name: 'annonces')]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(name: 'id_users', nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 280)]
    private ?string $nom = null;

    #[ORM\Column(length: 280)]
    private ?string $prix = null;

    #[ORM\Column(name: 'type_transaction', length: 20)]
    private ?string $typeTransaction = null;

    #[ORM\Column(name: 'property_type', length: 20)]
    private ?string $propertyType = null;

    #[ORM\Column(length: 280)]
    private ?string $ville = null;

    #[ORM\Column(length: 500)]
    private ?string $descriptions = null;

    #[ORM\Column(name: 'frontPicture', length: 280)]
    private ?string $frontPicture = null;

    #[ORM\Column(name: 'backPicture', length: 280)]
    private ?string $backPicture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getTypeTransaction(): ?string
    {
        return $this->typeTransaction;
    }

    public function setTypeTransaction(string $typeTransaction): static
    {
        $this->typeTransaction = $typeTransaction;
        return $this;
    }

    public function getPropertyType(): ?string
    {
        return $this->propertyType;
    }

    public function setPropertyType(string $propertyType): static
    {
        $this->propertyType = $propertyType;
        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;
        return $this;
    }

    public function getDescriptions(): ?string
    {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): static
    {
        $this->descriptions = $descriptions;
        return $this;
    }

    public function getFrontPicture(): ?string
    {
        return $this->frontPicture;
    }

    public function setFrontPicture(string $frontPicture): static
    {
        $this->frontPicture = $frontPicture;
        return $this;
    }

    public function getBackPicture(): ?string
    {
        return $this->backPicture;
    }

    public function setBackPicture(string $backPicture): static
    {
        $this->backPicture = $backPicture;
        return $this;
    }
}
