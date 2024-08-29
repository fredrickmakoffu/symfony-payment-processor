<?php

namespace App\Controller;

use App\Dto\Requests\PaymentRequest;
use App\Services\Payments\AciPaymentGateway;
use App\Services\Payments\Shift4PaymentGateway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\Responses\ApiResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

class PaymentGatewayController extends AbstractController
{
	public function __construct(
		private ApiResponseBuilder $responseBuilder, // Inject the ApiResponseBuilder
		private ValidatorInterface $validator, // Inject the ValidatorInterface
		private AciPaymentGateway $aciPaymentService, // Inject the AciPaymentProcessingService
		private Shift4PaymentGateway $shift4PaymentService // Inject the Shift4PaymentProcessingService
	)
	{}

	/**
	 * Process the payment
	 *
	 * @param string $payment_system
	 * @param PaymentRequest $request
	 * @return JsonResponse
	 */

  public function process(string $payment_system, PaymentRequest $request): Response
  {
   	try {
    	match ($payment_system) {
				'aci' => $this->aciPaymentService->process($request),
				'shift4' => $this->shift4PaymentService->process($request),
				default => throw new \Exception('Given payment system not recognized')
			};
    } catch (\Exception $e) {
        // Catch other exceptions
      return $this->responseBuilder->error('An unexpected error occurred', ['error_message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    return $this->responseBuilder->success('Success! Payment processed', (array) $request);
  }
}
