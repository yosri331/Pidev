<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 * @Vich\Uploadable
 */
class Produit
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
     * @Assert\NotBlank(message="Nom du produit est obligatoire")
     * @Groups("produit")
     */
    private $nomprod;

    /**
     * @ORM\Column(type="string", length=255)
      * @Assert\NotBlank(message="description du produit est obligatoire")
     * @Groups("produit")
     */
    private $dsecriptionprod;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Nom du produit est obligatoire")
     * @Groups("produit")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="disponibilité du produit est obligatoire")
     * @Groups("produit")
     */
    private $disponibilite;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="prix du produit est obligatoire")
     * @Groups("produit")
     */
    private $prix;

    /**
     * @ORM\Column(type="boolean")
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="produit")
     * @Groups("produit")
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $imageprod;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="imageprod")
     * @var File
     */
    private $imageFile;





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
    public function getPromo(): ?bool
    {
        return $this->promo;
    }

    public function setPromo(bool $promo): self
    {
        $this->promo = $promo;

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

    /**
     * @return string
     */
    public function getImageprod()
    {
        return $this->imageprod;
    }

    /**
     * @param string $imageprod
     */
    public function setImageprod(?string $imageprod): self
    {
        $this->imageprod = $imageprod;
        return $this;
    }


    public function getImageFile()
    {
        return $this->imageFile;
    }


    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($imageFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }

    }

}
