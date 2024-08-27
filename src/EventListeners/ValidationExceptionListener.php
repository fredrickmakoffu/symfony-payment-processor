<?php

namespace App\EventListeners;

use App\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use App\Services\Responses\ApiResponseBuilder;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
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
    	$errors = $exception->getErrors();
      $response = $this->responseBuilder->error($exception->getValidationMessage(), $errors, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
      $event->setResponse($response);

      return;
    }

    if ($exception instanceof NotFoundHttpException) {
      $response = $this->responseBuilder->error($exception->getMessage(), [], JsonResponse::HTTP_NOT_FOUND);
      $event->setResponse($response);

      return;
    }

    if ($exception instanceof MethodNotAllowedHttpException) {
			$response = $this->responseBuilder->error($exception->getMessage(), [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
			$event->setResponse($response);

			return;
		}

    if($exception instanceof \Exception) {
			$response = $this->responseBuilder->error($exception->getMessage(), [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
			$event->setResponse($response);

			return;
		}
  }
}
