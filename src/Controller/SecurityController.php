<?php

namespace App\Controller;

use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="app_security", methods={"GET"})
     * @OA\Get(
     *     path="/security",
     *     tags={"Security"},
     *     summary="Get security message",
     *     description="Returns a security message",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function security(): Response
    {
        return $this->json(['message' => 'Hello from SecurityController!']);
    }
}

