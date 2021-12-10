<?php

namespace App\Controller;

use App\Domain\Brand\BrandService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BrandController
{
    private BrandService $service;

    public function __construct(BrandService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/brand/all")
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        return new JsonResponse($this->service->find());
    }
}