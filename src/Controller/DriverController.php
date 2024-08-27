<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Driver;
use App\Entity\DriverLog;
use App\Form\DriverType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DriverController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/api/drivers', name: 'get_drivers', methods: ['GET'])]
    public function getDrivers(): JsonResponse
    {
        $drivers = $this->entityManager->getRepository(Driver::class)->findAll();
        $data = [];

        foreach ($drivers as $driver) {
            $data[] = [
                'id' => $driver->getId(),
                'name' => $driver->getName(),
                'birthdate' => $driver->getBirthdate()->format('Y-m-d'),
                'car' => $driver->getCar() ? [
                    'id' => $driver->getCar()->getId(),
                    'brand' => $driver->getCar()->getBrand(),
                    'model' => $driver->getCar()->getModel(),
                    'licensePlate' => $driver->getCar()->getLicensePlate(),
                ] : null,
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/api/drivers', name: 'driver_create', methods: ['POST'])]
    public function createDriver(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $driver = new Driver();
        $driver->setName($data['name']);
        $driver->setBirthdate(new \DateTime($data['birthdate']));

        $car = $this->entityManager->getRepository(Car::class)->find($data['car']);
        if ($car) {
            $driver->setCar($car);
        }

        $this->entityManager->persist($driver);
        $this->entityManager->flush();

        return new JsonResponse([
            'id' => $driver->getId(),
            'name' => $driver->getName(),
            'birthdate' => $driver->getBirthdate()->format('Y-m-d'),
            'car' => $car ? [
                'id' => $car->getId(),
                'brand' => $car->getBrand(),
                'model' => $car->getModel(),
                'licensePlate' => $car->getLicensePlate(),
            ] : null,
        ], JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/drivers/{id}', name: 'get_detail_driver', methods: ['GET'])]
    public function getDriver(Driver $driver): JsonResponse
    {
        return new JsonResponse([
            'id' => $driver->getId(),
            'name' => $driver->getName(),
            'birthdate' => $driver->getBirthdate()->format('Y-m-d'),
            'car' => $driver->getCar() ? [
                'id' => $driver->getCar()->getId(),
                'brand' => $driver->getCar()->getBrand(),
                'model' => $driver->getCar()->getModel(),
            ] : null,
        ]);
    }

    #[Route('/api/drivers/{id}', name: 'driver_update', methods: ['PUT'])]
    public function updateDriver(Request $request, Driver $driver): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $oldCar = $driver->getCar();

        $driver->setName($data['name']);
        $driver->setBirthdate(new \DateTime($data['birthdate']));

        $car = $this->entityManager->getRepository(Car::class)->find($data['car']);
        if ($car) {
            $driver->setCar($car);
        }

        if ($oldCar !== $car) {
            $log = new DriverLog();
            $log->setDriver($driver);
            $log->setOldCar($oldCar);
            $log->setNewCar($car);
            $log->setChangedAt(new \DateTimeImmutable());
            $this->entityManager->persist($log);
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'id' => $driver->getId(),
            'name' => $driver->getName(),
            'birthdate' => $driver->getBirthdate()->format('Y-m-d'),
            'car' => $car ? [
                'id' => $car->getId(),
                'brand' => $car->getBrand(),
                'model' => $car->getModel(),
                'licensePlate' => $car->getLicensePlate(),
            ] : null,
        ]);
    }

    #[Route('/api/driver-logs', name: 'get_driver_logs', methods: ['GET'])]
    public function getDriverLogs(): JsonResponse
    {
        $logs = $this->entityManager->getRepository(DriverLog::class)->findAll();
        $data = [];

        foreach ($logs as $log) {
            $data[] = [
                'id' => $log->getId(),
                'driver' => [
                    'id' => $log->getDriver()->getId(),
                    'name' => $log->getDriver()->getName(),
                ],
                'oldCar' => $log->getOldCar() ? [
                    'id' => $log->getOldCar()->getId(),
                    'brand' => $log->getOldCar()->getBrand(),
                    'model' => $log->getOldCar()->getModel(),
                ] : null,
                'newCar' => $log->getNewCar() ? [
                    'id' => $log->getNewCar()->getId(),
                    'brand' => $log->getNewCar()->getBrand(),
                    'model' => $log->getNewCar()->getModel(),
                ] : null,
                'changedAt' => $log->getChangedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse($data);
    }
}
