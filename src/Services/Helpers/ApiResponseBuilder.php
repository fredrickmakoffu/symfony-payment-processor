<?php

namespace App\Services\Helpers;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Dto\ApiResponse;
use App\Dto\Helpers\ErrorApiResponse;
use App\Dto\Helpers\SuccessApiResponse;

class ApiResponseBuilder
{
  public function success(string $message, array $data = null, $httpStatusCode = JsonResponse::HTTP_OK): JsonResponse
  {
    return new JsonResponse(
    	new SuccessApiResponse($message, $data),
     	$httpStatusCode
    );
  }

  public function error(string $message, array $errors = null, $httpStatusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
  {
    return new JsonResponse(
    	new ErrorApiResponse($message, $errors),
     	$httpStatusCode
    );
  }
}
