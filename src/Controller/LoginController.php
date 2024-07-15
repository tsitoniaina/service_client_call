<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class LoginController extends AbstractController
{
    /**
     * @Route(path="/docs", name="api_docs")
     */
    public function __invoke(SerializerInterface $serializer)
    {
        $spec = $serializer->serialize(
            $this->get('api_platform.swagger.extractor')->getSwagger(),
            'json'
        );

        return new JsonResponse($spec, 200, [], true);
    }
}

