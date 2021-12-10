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
     * Успешное выполнение
     *
     * @return JsonResponse
     */
    private function success(): JsonResponse
    {
        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/brand/all")
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        return new JsonResponse($this->service->getAll());
    }

    /**
     * @Route("/brand/create", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function create(string $name): JsonResponse
    {
        $this->service->create($name);

        return $this->success();
    }

    /**
     * @Route("/brand/update/{id}", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function update(int $id, string $name): JsonResponse
    {
        $this->service->update($id, $name);

        return $this->success();
    }

    /**
     * @Route("/brand/delete/{id}", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->success();
    }
}