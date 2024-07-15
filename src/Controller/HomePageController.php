<?php

namespace App\Controller;

use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Info(title: 'Homepage API', version: '1.0')]
class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    #[OA\Get(
        path: '/',
        operationId: 'getHomePage',
        tags: ['Homepage'],
        summary: 'Get the homepage',
        responses: [
            '200' => [
                'description' => 'The homepage',
                'content' => [
                    'text/html' => [
                        'schema' => [
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
        ]
    )]
    public function index(): Response
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
}

