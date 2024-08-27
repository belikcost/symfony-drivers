<?php

namespace App\Entity;

use App\Repository\DriverRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DriverRepository::class)]
class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private $name;

    #[ORM\Column(type: "date")]
    private $birthdate;

    #[ORM\ManyToOne("App\Entity\Car")]
    #[ORM\JoinColumn(nullable: false)]
    private $car;

    /**
     * @var Collection<int, DriverLog>
     */
    #[ORM\OneToMany(targetEntity: DriverLog::class, mappedBy: 'driver')]
    private Collection $driverLogs;

    public function __construct()
    {
        $this->driverLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCar(): Car
    {
        return $this->car;
    }


    public function setCar(Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function setName(string $value): self
    {
        $this->name = $value;

        return $this;
    }

    public function setBirthdate(DateTime $value): self
    {
        $this->birthdate = $value;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthdate(): DateTime
    {
        return $this->birthdate;
    }

    public function getDriverLogs(): Collection
    {
        return $this->driverLogs;
    }

    public function addDriverLog(DriverLog $driverLog): static
    {
        if (!$this->driverLogs->contains($driverLog)) {
            $this->driverLogs->add($driverLog);
            $driverLog->setDriver($this);
        }

        return $this;
    }

    public function removeDriverLog(DriverLog $driverLog): static
    {
        if ($this->driverLogs->removeElement($driverLog)) {
            if ($driverLog->getDriver() === $this) {
                $driverLog->setDriver(null);
            }
        }

        return $this;
    }


}
