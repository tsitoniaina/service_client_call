<?php
// namespace App\Controller;

// use App\Entity\User;
// use Doctrine\ORM\EntityManagerInterface;
// use OpenApi\Annotations as OA;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Security\Core\Exception\BadCredentialsException;
// use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// class LoginController extends AbstractController
// {
//     private $entityManager;
//     private $passwordHasher;

//     public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
//     {
//         $this->entityManager = $entityManager;
//         $this->passwordHasher = $passwordHasher;
//     }

//     /**
//      * @Route("/login", name="app_login", methods={"POST"})
//      * @OA\Post(
//      *     path="/login",
//      *     summary="Login a user",
//      *     description="Login a user with email and password",
//      *     @OA\RequestBody(
//      *         required=true,
//      *         @OA\JsonContent(
//      *             @OA\Property(property="email", type="string", example="user@example.com"),
//      *             @OA\Property(property="password", type="string", example="password")
//      *         )
//      *     ),
//      *     @OA\Response(
//      *         response=200,
//      *         description="Login successful",
//      *         @OA\JsonContent(
//      *             @OA\Property(property="message", type="string", example="Login successful")
//      *         )
//      *     ),
//      *     @OA\Response(
//      *         response=400,
//      *         description="Bad request",
//      *         @OA\JsonContent(
//      *             @OA\Property(property="message", type="string", example="Email and password are required.")
//      *         )
//      *     ),
//      *     @OA\Response(
//      *         response=401,
//      *         description="Unauthorized",
//      *         @OA\JsonContent(
//      *             @OA\Property(property="message", type="string", example="Invalid email or password.")
//      *         )
//      *     )
//      * )
//      */
//     public function login(Request $request): JsonResponse
//     {
//         $data = json_decode($request->getContent(), true);

//         $email = $data['email'] ?? null;
//         $password = $data['password'] ?? null;

//         if (!$email || !$password) {
//             throw new BadCredentialsException('Email and password are required.');
//         }

//         $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

//         if (!$user) {
//             throw new BadCredentialsException('Invalid email or password.');
//         }

//         if (!$this->passwordHasher->isPasswordValid($user, $password)) {
//             throw new BadCredentialsException('Invalid email or password.');
//         }

//         return $this->json(['message' => 'Login successful'], JsonResponse::HTTP_OK);
//     }
// }


namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/login", name="app_login", methods={"POST"})
     * @OA\Post(
     *     path="/login",
     *     summary="Login a user",
     *     description="Login a user with email and password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login successful")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email and password are required.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid email or password.")
     *         )
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return new JsonResponse(['message' => 'Email and password are required.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            return new JsonResponse(['message' => 'Invalid email or password.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse(['message' => 'Login successful'], JsonResponse::HTTP_OK);
    }
}
