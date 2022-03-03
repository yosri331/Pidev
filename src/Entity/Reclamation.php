<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use phpDocumentor\Reflection\Types\ClassString;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 */
class Reclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=250)
     * @var string A "Y-m-d" formatted value
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="reclamations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_prod;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('date', new Assert\Date());
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdUser(): ?user
    {
        return $this->id_user;
    }

    public function setIdUser(?user $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdProd(): ?int
    {
        return $this->id_prod;
    }

    public function setIdProd(int $id_prod): self
    {
        $this->id_prod = $id_prod;

        return $this;
    }

    public function __toString()
    {
        return  $this->id_user;
    }
}
