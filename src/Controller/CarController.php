<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/cars', name: 'get_cars', methods: ['GET'])]
    public function getCars(): JsonResponse
    {
        $cars = $this->entityManager->getRepository(Car::class)->findAll();
        $data = [];

        foreach ($cars as $car) {
            $data[] = [
                'id' => $car->getId(),
                'brand' => $car->getBrand(),
                'model' => $car->getModel(),
                'licensePlate' => $car->getLicensePlate(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/api/cars', name: 'create_car', methods: ['POST'])]
    public function createCar(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $car = new Car();
        $car->setBrand($data['brand']);
        $car->setModel($data['model']);
        $car->setLicensePlate($data['licensePlate']);

        $this->entityManager->persist($car);
        $this->entityManager->flush();

        return new JsonResponse([
            'id' => $car->getId(),
            'brand' => $car->getBrand(),
            'model' => $car->getModel(),
            'licensePlate' => $car->getLicensePlate(),
        ], JsonResponse::HTTP_CREATED);
    }
}
