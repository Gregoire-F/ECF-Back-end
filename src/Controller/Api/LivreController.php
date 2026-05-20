<?php

namespace App\Controller\Api;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/livres')]
class LivreController extends AbstractController
{
    public function __construct(
        private LivreRepository $livreRepository,
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
    ) {}

    /**
     * GET /api/livres - Liste tous les livres
     */

    #[Route('', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $livres = $this->livreRepository->findAll();

        // Avec Serializer
        $json = $this->serializer->serialize($livres, 'json');

        return JsonResponse::fromJsonString($json, Response::HTTP_OK);
    }

    /**
     * GET /api/livres/{id} - Détail d'un livre
     */
    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $livre = $this->livreRepository->find($id);

        if (!$livre) {
            return new JsonResponse(
                ['error' => 'Livre non trouvé'],
                Response::HTTP_NOT_FOUND
            );
        }

        // Avec Serializer
        $json = $this->serializer->serialize($livre, 'json');

        return JsonResponse::fromJsonString($json, Response::HTTP_OK);
    }

    /**
     * POST /api/livres - Créer un nouveau livre
     */
    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            // Validation des champs obligatoires
            $errors = [];
            if (empty($data['titre'])) {
                $errors[] = 'Le titre est obligatoire';
            }
            if (empty($data['auteur'])) {
                $errors[] = 'L\'auteur est obligatoire';
            }
            if (!isset($data['disponible'])) {
                $errors[] = 'Le champ disponible est obligatoire';
            }

            if (!empty($errors)) {
                return new JsonResponse(
                    ['errors' => $errors],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // Créer le livre
            $livre = new Livre();
            $livre->setTitre($data['titre']);
            $livre->setAuteur($data['auteur']);
            $livre->setIsbn($data['isbn'] ?? null);

            // Créer la date
            if (!empty($data['date_publication'])) {
                try {
                    $date = new \DateTime($data['date_publication']);
                    $livre->setDatePublication($date);
                } catch (\Exception) {
                    return new JsonResponse(
                        ['error' => 'Format de date invalide. Utilisez YYYY-MM-DD'],
                        Response::HTTP_BAD_REQUEST
                    );
                }
            }

            $livre->setDisponible((bool)$data['disponible']);

            // Persister en base
            $this->entityManager->persist($livre);
            $this->entityManager->flush();

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($livre, 'json'),
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                ['error' => 'Erreur lors de la création du livre'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * PUT /api/livres/{id} - Modifier un livre
     */
    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $livre = $this->livreRepository->find($id);

        if (!$livre) {
            return new JsonResponse(
                ['error' => 'Livre non trouvé'],
                Response::HTTP_NOT_FOUND
            );
        }

        try {
            $data = json_decode($request->getContent(), true);

            // Mettre à jour les champs fournis
            if (isset($data['titre'])) {
                $livre->setTitre($data['titre']);
            }
            if (isset($data['auteur'])) {
                $livre->setAuteur($data['auteur']);
            }
            if (isset($data['isbn'])) {
                $livre->setIsbn($data['isbn']);
            }
            if (isset($data['date_publication'])) {
                try {
                    $date = new \DateTime($data['date_publication']);
                    $livre->setDatePublication($date);
                } catch (\Exception) {
                    return new JsonResponse(
                        ['error' => 'Format de date invalide. Utilisez YYYY-MM-DD'],
                        Response::HTTP_BAD_REQUEST
                    );
                }
            }
            if (isset($data['disponible'])) {
                $livre->setDisponible((bool)$data['disponible']);
            }

            $this->entityManager->flush();

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($livre, 'json'),
                Response::HTTP_OK
            );
        } catch (\Exception) {
            return new JsonResponse(
                ['error' => 'Erreur lors de la modification du livre'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * DELETE /api/livres/{id} - Supprimer un livre
     */
    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $livre = $this->livreRepository->find($id);

        if (!$livre) {
            return new JsonResponse(
                ['error' => 'Livre non trouvé'],
                Response::HTTP_NOT_FOUND
            );
        }

        try {
            $this->entityManager->remove($livre);
            $this->entityManager->flush();

            return new JsonResponse(
                ['message' => 'Livre supprimé avec succès'],
                Response::HTTP_OK
            );
        } catch (\Exception) {
            return new JsonResponse(
                ['error' => 'Erreur lors de la suppression du livre'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
