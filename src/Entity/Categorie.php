<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("produit")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Nom du produit est obligatoire")
     * @Groups("produit")
     */
    private $nomcat;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="descriprtion du produit est obligatoire")
     * @Groups("produit")
     */
    private $descriptioncat;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="categorie")
     * @Groups("produit")
     */
    private $produit;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomcat(): ?string
    {
        return $this->nomcat;
    }

    public function setNomcat(string $nomcat): self
    {
        $this->nomcat = $nomcat;

        return $this;
    }

    public function getDescriptioncat(): ?string
    {
        return $this->descriptioncat;
    }

    public function setDescriptioncat(string $descriptioncat): self
    {
        $this->descriptioncat = $descriptioncat;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
            $produit->setCategorie($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategorie() === $this) {
                $produit->setCategorie(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->nomcat;

    }
}
