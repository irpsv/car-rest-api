<?php

namespace App\Controller;

use App\Domain\Brand\BrandService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param int $id
     * @return JsonResponse
     */
    private function success(int $id): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'id' => $id,
        ]);
    }

    /**
     * @Route("/brand/all")
     *
     * @return JsonResponse
     */
    public function all(Request $request): JsonResponse
    {
        $page = (int) $request->query->get('page', 1);
        $size = (int) $request->query->get('size', 50);

        if ($size < 1) {
            $size = 1;
        }
        if ($page < 1) {
            $page = 1;
        }

        $items = $this->service->getRepo()->getAll(null, $page, $size);

        return new JsonResponse($items);
    }

    /**
     * @Route("/brand/create", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $name = (string) $request->request->get('name');
        $brand = $this->service->create($name);

        return $this->success($brand->getId());
    }

    /**
     * @Route("/brand/update/{id}", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $name = (string) $request->request->get('name');
        $this->service->update($id, $name);

        return $this->success($id);
    }

    /**
     * @Route("/brand/delete/{id}", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->success($id);
    }
}