<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Throwable;

class ErrorController
{
    public function show(Throwable $exception, ?DebugLoggerInterface $logger)
    {
        $status = $exception->getCode() ?: 500;

        return new JsonResponse([
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ], $status);
    }
}