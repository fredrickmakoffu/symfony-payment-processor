<?php

namespace App\Services\Responses;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Dto\ApiResponse;
use App\Dto\Responses\ErrorApiResponse;
use App\Dto\Responses\SuccessApiResponse;

class ApiResponseBuilder
{
	const headers = [
		'Content-Type' => 'application/json'
	];

  public function success(string $message, array $data = null, $httpStatusCode = JsonResponse::HTTP_OK): JsonResponse
  {
    return new JsonResponse(
    	new SuccessApiResponse($message, $data),
     	$httpStatusCode,
      self::headers
    );
  }

  public function error(string $message, array $errors = null, $httpStatusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
  {
    return new JsonResponse(
    	new ErrorApiResponse($message, $errors),
     	422,
      self::headers
    );
  }
}
