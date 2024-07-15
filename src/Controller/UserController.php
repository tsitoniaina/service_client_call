<?php

namespace App\Controller;

use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/docs", name="api_docs", methods={"GET"})
     * @OA\Get(
     *     path="/docs",
     *     summary="Generate Swagger documentation",
     *     tags={"docs"},
     *     @OA\Response(
     *         response=200,
     *         description="Returns the Swagger documentation"
     *     )
     * )
     */
    public function generateDocs(): Response
    {
        return $this->render('swagger/index.html.twig');
    }
}

