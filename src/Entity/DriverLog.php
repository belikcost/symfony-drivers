<?php

namespace App\Entity;

use App\Repository\DriverLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DriverLogRepository::class)]
class DriverLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'driverLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Driver $driver = null;

    #[ORM\ManyToOne]
    private ?Car $oldCar = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $newCar = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $changedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): static
    {
        $this->driver = $driver;

        return $this;
    }

    public function getOldCar(): ?Car
    {
        return $this->oldCar;
    }

    public function setOldCar(?Car $oldCar): static
    {
        $this->oldCar = $oldCar;

        return $this;
    }

    public function getNewCar(): ?Car
    {
        return $this->newCar;
    }

    public function setNewCar(?Car $newCar): static
    {
        $this->newCar = $newCar;

        return $this;
    }

    public function getChangedAt(): ?\DateTimeImmutable
    {
        return $this->changedAt;
    }

    public function setChangedAt(\DateTimeImmutable $changedAt): static
    {
        $this->changedAt = $changedAt;

        return $this;
    }
}
