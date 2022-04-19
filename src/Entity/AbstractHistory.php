<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractHistory
{
    /**
     * @ORM\Column(type="datetime_immutable", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     */
    protected DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeImmutable $newDate
     * @return $this
     */
    public function setCreatedAt(DateTimeImmutable $newDate): self
    {
        $this->createdAt = $newDate;
        return $this;
    }
}
