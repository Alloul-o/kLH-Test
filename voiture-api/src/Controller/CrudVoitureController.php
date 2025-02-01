<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CrudVoitureController extends AbstractController
{


    private $entityManager;
    private $voitureRepository;

    public function __construct(EntityManagerInterface $entityManager, VoitureRepository $voitureRepository)
    {
        $this->entityManager = $entityManager;
        $this->voitureRepository = $voitureRepository;
    }


    
    public function index(): JsonResponse
    {
        $voitures = $this->voitureRepository->findAll();
        return $this->json($voitures, 200, [], ['groups' => 'voiture:read']);
    }

    
    public function show(int $id): JsonResponse
    {
        $voiture = $this->voitureRepository->find($id);

        if (!$voiture) {
            return $this->json(['error' => 'Voiture not found'], 404);
        }

        return $this->json($voiture, 200, [], ['groups' => 'voiture:read']);
    }

   
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        
        dump('Received data:', $data);

        if (!$data) {
            return $this->json(['error' => 'Invalid JSON payload'], 400);
        }

        if (!isset($data['model']) || !isset($data['kmh'])) {
            return $this->json(['error' => 'Missing required fields: model or kmh'], 400);
        }

        $voiture = new Voiture();
        $voiture->setModel($data['model']);
        $voiture->setKmh((int) $data['kmh']);
        $voiture->setCharacteristics($data['characteristics'] ?? []);

      

        // Validate the entity
        $errors = $validator->validate($voiture);
        if (count($errors) > 0) {
            return $this->json(['error' => (string) $errors], 400);
        }

        $entityManager->persist($voiture); 
        $entityManager->flush();

        return $this->json($voiture, 201, [], ['groups' => 'voiture:read']);
    }



    
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $voiture = $this->voitureRepository->find($id);

        if (!$voiture) {
            return $this->json(['error' => 'Voiture not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (isset($data['model'])) $voiture->setModel($data['model']);
        if (isset($data['kmh'])) $voiture->setKmh($data['kmh']);
        if (isset($data['characteristics'])) $voiture->setCharacteristics($data['characteristics']);

        
        $errors = $validator->validate($voiture);
        if (count($errors) > 0) {
            return $this->json(['error' => (string) $errors], 400);
        }

        $this->entityManager->flush();

        return $this->json($voiture, 200, [], ['groups' => 'voiture:read']);
    }

    
    public function delete(int $id): JsonResponse
    {
        $voiture = $this->voitureRepository->find($id);

        if (!$voiture) {
            return $this->json(['error' => 'Voiture not found'], 404);
        }

        $this->entityManager->remove($voiture);
        $this->entityManager->flush();

        return $this->json(['message' => 'Voiture deleted successfully'], 204);
    }


    
    public function calculateTime(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $distance = $data['distance'] ?? null;
        $model = $data['model'] ?? null;

        if (!$distance || !$model) {
            return $this->json(['error' => 'Both distance and model are required.'], 400);
        }

        $voiture = $this->voitureRepository->findOneBy(['model' => $model]);

        if (!$voiture) {
            return $this->json(['error' => 'Car model not found.'], 404);
        }

        if ($voiture->getKmh() > 0) {
            $time = $distance / $voiture->getKmh();
        } else {
            return $this->json(['error' => 'Speed must be greater than zero.'], 400);
        }

        return $this->json([
            'model' => $model,
            'distance_km' => $distance,
            'speed_kmh' => $voiture->getKmh(),
            'time_hours' => round($time, 2)
        ]);
    }
}
