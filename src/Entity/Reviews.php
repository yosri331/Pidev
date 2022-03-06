<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Event;
use App\Repository\ReviewsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     */
    #[ORM\Column(type: 'string', length: 50)]
    private $nom;
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=10)
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $description;
    /**
     * @Assert\NotBlank
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    private $score;
  
    #[ORM\Column(type: 'date')]
    private $date;


    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: 'id_review')]
    #[ORM\JoinColumn(nullable: false)]
    private Event $event;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

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

    public function getIdEvent(): ?int
    {
        $event=$this->event;
        return $event->getId();
    }



    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

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
