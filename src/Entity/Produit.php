<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 *
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Nom du produit est obligatoire")
     */
    private $nomprod;

    /**
     * @ORM\Column(type="string", length=255)
      * @Assert\NotBlank(message="description du produit est obligatoire")
     */
    private $dsecriptionprod;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Nom du produit est obligatoire")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="disponibilité du produit est obligatoire")
     */
    private $disponibilite;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="prix du produit est obligatoire")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="produit")
     */
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomprod(): ?string
    {
        return $this->nomprod;
    }

    public function setNomprod(string $nomprod): self
    {
        $this->nomprod = $nomprod;

        return $this;
    }

    public function getDsecriptionprod(): ?string
    {
        return $this->dsecriptionprod;
    }

    public function setDsecriptionprod(string $dsecriptionprod): self
    {
        $this->dsecriptionprod = $dsecriptionprod;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(string $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
