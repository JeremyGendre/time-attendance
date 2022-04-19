<?php

namespace App\Entity;

use App\Repository\ExtraTickingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExtraTickingRepository::class)
 */
class ExtraTicking extends AbstractHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $startDate;

    /**
     * @ORM\Column(type="time")
     */
    private $endDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Ticking::class, inversedBy="extraTickings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ticking;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTicking(): ?Ticking
    {
        return $this->ticking;
    }

    public function setTicking(?Ticking $ticking): self
    {
        $this->ticking = $ticking;

        return $this;
    }
}
