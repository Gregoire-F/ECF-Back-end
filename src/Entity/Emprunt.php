<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_emprunt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_retour_prevue = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_retour_effective = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]//Suppression en cascade : si un livre est supprimé, tous les emprunts associés sont aussi supprimés
    #[Assert\Expression(
        expression: 'this.getLivre() === null || this.getLivre().isDisponible() === true',
        message: 'Ce livre n\'est pas disponible.'
    )]
    private ?Livre $livre = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]//Suppression en cascade : si un abonné est supprimé, tous les emprunts associés sont aussi supprimés
    private ?Abonne $abonne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmprunt(): ?\DateTime
    {
        return $this->date_emprunt;
    }

    public function setDateEmprunt(\DateTime $date_emprunt): static
    {
        $this->date_emprunt = $date_emprunt;

        return $this;
    }

    public function getDateRetourPrevue(): ?\DateTime
    {
        return $this->date_retour_prevue;
    }

    public function setDateRetourPrevue(\DateTime $date_retour_prevue): static
    {
        $this->date_retour_prevue = $date_retour_prevue;

        return $this;
    }

    public function getDateRetourEffective(): ?\DateTime
    {
        return $this->date_retour_effective;
    }

    public function setDateRetourEffective(?\DateTime $date_retour_effective): static
    {
        $this->date_retour_effective = $date_retour_effective;

        return $this;
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

    public function getAbonne(): ?Abonne
    {
        return $this->abonne;
    }
    public function setAbonne(?Abonne $abonne): static
    {
        $this->abonne = $abonne;
        return $this;
    }
}
