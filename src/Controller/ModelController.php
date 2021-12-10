<?php

namespace App\Controller;

use App\Domain\Model\ModelService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ModelController
{
    private ModelService $service;

    public function __construct(ModelService $service)
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
     * @Route("/model/all")
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

        $criteria = [];

        $brands = (string) $request->query->get('brands', '');
        if ($brands) {
            $criteria['brand'] = explode(',', $brands);
        }

        $criteria = array_filter($criteria);
        $items = $this->service->getRepo()->getAll($criteria, $page, $size);

        return new JsonResponse($items);
    }

    /**
     * @Route("/model/create", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $name = (string) $request->request->get('name');
        $brandId = (int) $request->request->get('brandId');

        $entity = $this->service->create($brandId, $name);

        return $this->success($entity->getId());
    }

    /**
     * @Route("/model/update/{id}", methods={"POST"})
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
     * @Route("/model/delete/{id}", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->success($id);
    }
}