<?php

namespace App\Services\Responses;

use Symfony\Component\HttpFoundation\JsonResponse;
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

  /**
	 * @param string $message
	 * @param array $errors
	 * @param int $httpStatusCode
	 * @return JsonResponse
	 */
  public function error(string $message, array $errors = [], $httpStatusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
  {
    return new JsonResponse(
    	new ErrorApiResponse($message, $errors),
     	$httpStatusCode,
      self::headers
    );
  }
}
