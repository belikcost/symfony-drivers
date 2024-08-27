<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private string $licensePlate;

    #[ORM\Column]
    private string $brand;

    #[ORM\Column]
    private string $model;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setLicensePlate(string $value): Car
    {
        $this->licensePlate = $value;
        return $this;
    }

    public function setBrand(string $value): Car
    {
        $this->brand = $value;
        return $this;
    }

    public function setModel(string $value): Car
    {
        $this->model = $value;
        return $this;
    }
}
