<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="app_security", methods={"GET"})
     */
    public function security(): Response
    {
        return $this->json(['message' => 'Hello from SecurityController!']);
    }
}
