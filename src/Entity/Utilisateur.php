<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("user")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     * @Groups("user")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=40)
     * @Groups("user")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("user")
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     * @Groups("user")
     */
    private $num_tel;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups("user")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("user")
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("user")
     */
    private $password;

    

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="utilisateur")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=Reviews::class, mappedBy="utilisateur")
     */
    private $Reviews;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->Reviews = new ArrayCollection();
    }

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->num_tel;
    }

    public function setNumTel(int $num_tel): self
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setUtilisateur($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getUtilisateur() === $this) {
                $event->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviews(): Collection
    {
        return $this->Reviews;
    }

    public function addReview(Reviews $review): self
    {
        if (!$this->Reviews->contains($review)) {
            $this->Reviews[] = $review;
            $review->setUtilisateur($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): self
    {
        if ($this->Reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUtilisateur() === $this) {
                $review->setUtilisateur(null);
            }
        }

        return $this;
    }
}
