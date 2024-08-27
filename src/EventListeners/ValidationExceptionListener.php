<?php

namespace App\EventListeners;

use App\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use App\Services\Responses\ApiResponseBuilder;

class ValidationExceptionListener
{
	public function __construct(private ApiResponseBuilder $responseBuilder) {}

	/**
	 * Handle validation exceptions
	 * @param ExceptionEvent $event
	 */
  public function onKernelException(ExceptionEvent $event)
  {
    $exception = $event->getThrowable();

    if ($exception instanceof ValidationException) {
      $response = $this->responseBuilder->error($exception->getValidationMessage(), $exception->getErrors(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
      $event->setResponse($response);
    }
  }
}
