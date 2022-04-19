<?php

namespace App\Entity;

use App\Repository\TickingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TickingRepository::class)
 */
class Ticking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $tickingDay;

    /**
     * @ORM\Column(type="time")
     */
    private $enterDate;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $breakDate;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $returnDate;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $exitDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ExtraTicking::class, mappedBy="ticking")
     */
    private $extraTickings;

    public function __construct()
    {
        $this->extraTickings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTickingDay(): ?\DateTimeInterface
    {
        return $this->tickingDay;
    }

    public function setTickingDay(\DateTimeInterface $tickingDay): self
    {
        $this->tickingDay = $tickingDay;

        return $this;
    }

    public function getEnterDate(): ?\DateTimeInterface
    {
        return $this->enterDate;
    }

    public function setEnterDate(\DateTimeInterface $enterDate): self
    {
        $this->enterDate = $enterDate;

        return $this;
    }

    public function getBreakDate(): ?\DateTimeInterface
    {
        return $this->breakDate;
    }

    public function setBreakDate(?\DateTimeInterface $breakDate): self
    {
        $this->breakDate = $breakDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getExitDate(): ?\DateTimeInterface
    {
        return $this->exitDate;
    }

    public function setExitDate(?\DateTimeInterface $exitDate): self
    {
        $this->exitDate = $exitDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, ExtraTicking>
     */
    public function getExtraTickings(): Collection
    {
        return $this->extraTickings;
    }

    public function addExtraTicking(ExtraTicking $extraTicking): self
    {
        if (!$this->extraTickings->contains($extraTicking)) {
            $this->extraTickings[] = $extraTicking;
            $extraTicking->setTicking($this);
        }

        return $this;
    }

    public function removeExtraTicking(ExtraTicking $extraTicking): self
    {
        if ($this->extraTickings->removeElement($extraTicking)) {
            // set the owning side to null (unless already changed)
            if ($extraTicking->getTicking() === $this) {
                $extraTicking->setTicking(null);
            }
        }

        return $this;
    }
}
