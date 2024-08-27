<?php

namespace App\Controller;

use App\Dto\Request\PaymentRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\Responses\ApiResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

class PaymentsController extends AbstractController
{
	private $responseBuilder;
	private $validator;

	public function __construct(ApiResponseBuilder $responseBuilder, ValidatorInterface $validator)
	{
	  $this->responseBuilder = $responseBuilder;
		$this->validator = $validator;
	}

	/**
	 * Process the payment
	 *
	 * @param string $payment_system
	 * @param Request $request
	 * @return JsonResponse
	 */

  public function process(string $payment_system, PaymentRequest $request): Response
  {
   	try {

    } catch (\Exception $e) {
        // Catch other exceptions
      return $this->responseBuilder->error('An unexpected error occurred', ['error_message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    return $this->responseBuilder->success('Success! Payment processed', (array) $request);
  }
}
