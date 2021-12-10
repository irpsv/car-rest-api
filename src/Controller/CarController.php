<?php

namespace App\Controller;

use App\Domain\Car\CarFilter;
use App\Domain\Car\CarService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CarController
{
    private CarService $service;

    public function __construct(CarService $service)
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
     * @Route("/car/all")
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

        $criteria = CarFilter::createFromRequest($request)->getCriteria();
        $items = $this->service->getRepo()->getAll($criteria, $page, $size);

        return new JsonResponse($items);
    }

    /**
     * @Route("/car/create", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $modificationId = (int) $request->request->get('modificationId');
        $bodyTypeId = (int) $request->request->get('bodyTypeId');
        $yearProduction = (int) $request->request->get('yearProduction');

        $entity = $this->service->create($modificationId, $bodyTypeId, $yearProduction);

        return $this->success($entity->getId());
    }

    /**
     * @Route("/car/update/{id}", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $this->service->update($id, []);

        return $this->success($id);
    }

    /**
     * @Route("/car/delete/{id}", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->success($id);
    }
}