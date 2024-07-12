<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/api/users", name="api_users", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'User created!'], JsonResponse::HTTP_CREATED);
    }

    /**
 * @Route("/api/users/{id}", name="api_update_user", methods={"POST"})
 */
    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Récupérer l'utilisateur depuis la base de données
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Mettre à jour les informations de l'utilisateur si les champs sont fournis
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }
        if (isset($data['password'])) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        }
        if (isset($data['phone'])) {
            $user->setPhone($data['phone']);
        }

        // Enregistrer les modifications
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'User updated!']);
    }

   /**
     * @Route("/api/users/{id}", name="api_get_user_by_id", methods={"GET"})
     */
    public function getUserById(int $id): JsonResponse
    {
        // Retrieve the user from the database
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Convert user entity to array
        $userData = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'role' => $user->getRoles()
            // Add other fields as needed
        ];

        return new JsonResponse($userData);
    }


}
