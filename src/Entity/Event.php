<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    /**
     *@Groups("post:read")
     */
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
     /**
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     * @Groups("post:read")
     */
    private $nom;
     /**
     * @Assert\NotBlank
     * @Assert\Length(min=10)
     * @Groups("post:read")
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $description;
  
    #[ORM\Column(type: 'date')]
    /**
     * @Groups("post:read")
     */
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Groups("post:read")
     */
    private $image;
    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @Groups("post:read")
     * @var File
     */
    private $imageFile;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    /**
     * @Groups("post:read")
     */
    private $participants;


    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Reviews::class, orphanRemoval: true)]
    /**
     * @Groups("post:read")
     */
    private $id_review;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'evenement')]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;

    public function __construct()
    {
        $this->id_review = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function count(){
        return count($this->id_review);
    }

    public function getIdEvent(): ?int
    {
        return $this->id_event;
    }

    public function setIdEvent(int $id_event): self
    {
        $this->id_event = $id_event;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getParticipants(): ?string
    {
        return $this->participants;
    }

    public function setParticipants(?string $participants): self
    {
        $this->participants = $this->participants.';'.$participants;

        return $this;
    }

   

  
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getIdReview(): Collection
    {
        return $this->id_review;
    }

    public function addIdReview(Reviews $idReview): self
    {
        if (!$this->id_review->contains($idReview)) {
            $this->id_review[] = $idReview;
            $idReview->setEvent($this);
        }

        return $this;
    }

    public function removeIdReview(Reviews $idReview): self
    {
        if ($this->id_review->removeElement($idReview)) {
            // set the owning side to null (unless already changed)
            if ($idReview->getEvent() === $this) {
                $idReview->setEvent(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
