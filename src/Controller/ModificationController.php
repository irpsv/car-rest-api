<?php

namespace App\Controller;

use App\Domain\Modification\ModificationService;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ModificationController
{
    private ModificationService $service;

    public function __construct(ModificationService $service)
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
     * @Route("/modification/all")
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

        $criteria = new Criteria();
        if ($name = (string) $request->query->get('name')) {
            $criteria->where(new Comparison('name', Comparison::CONTAINS, $name));
        }

        $items = $this->service->getRepo()->getAll($criteria, $page, $size);

        return new JsonResponse($items);
    }

    /**
     * @Route("/modification/create", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $values = (array) $request->request->get('values');
        $modificationId = (int) $request->request->get('modificationId');

        $entity = $this->service->create($modificationId, $values);

        return $this->success($entity->getId());
    }

    /**
     * @Route("/modification/update/{id}", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $values = (array) $request->request->get('values');
        $this->service->update($id, $values);

        return $this->success($id);
    }

    /**
     * @Route("/modification/delete/{id}", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->success($id);
    }
}