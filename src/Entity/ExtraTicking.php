<?php

namespace App\Entity;

use App\Repository\ExtraTickingRepository;
use App\Service\Utils\DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ExtraTickingRepository::class)
 */
class ExtraTicking extends AbstractHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"main","history"})
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     * @Groups({"main","history"})
     */
    private $startDate;

    /**
     * @ORM\Column(type="time")
     * @Groups({"main","history"})
     */
    private $endDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"main","history"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Ticking::class, inversedBy="extraTickings",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"main"})
     */
    private $ticking;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(DateTimeInterface $endDate): self
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

    /**
     * @return bool
     * @throws Exception
     * @Groups({"main","history"})
     */
    public function isDeletable():bool
    {
        $now = (new DateTime())->add(new \DateInterval('PT2H'));
        $date = $this->getTicking()->getTickingDay();
        $date->setTime($this->getEndDate()->format('H'),$this->getEndDate()->format('i'));
        return $now < $date;
    }

    /**
     * @Groups({"main","history"})
     * @param string $format
     * @return string
     */
    public function getFormattedStartDate(string $format = 'H:i'): string
    {
        return $this->getStartDate() ? $this->getStartDate()->format($format) : '';
    }

    /**
     * @Groups({"main","history"})
     * @param string $format
     * @return string
     */
    public function getFormattedEndDate(string $format = 'H:i'): string
    {
        return $this->getEndDate() ? $this->getEndDate()->format($format) : '';
    }
}
