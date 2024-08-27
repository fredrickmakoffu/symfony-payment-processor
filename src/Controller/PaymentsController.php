<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Dto\Request\PaymentRequest;
use App\Exceptions\ValidationException;
use App\Services\Responses\ApiResponseBuilder;
use Symfony\Component\Validator\ConstraintViolationList;
use Exception;

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
	 * @param string $system
	 * @param Request $request
	 * @return JsonResponse
	 */

  public function process(string $system, PaymentRequest $request): JsonResponse
  {

	 	return new JsonResponse([
			'test'=> 'test'
		], 422, ['Content-Type' => 'application/json']);
   	try {
    	// make payment

    } catch (\Exception $e) {
        // Catch other exceptions
      return $this->responseBuilder->error('An unexpected error occurred', ['error_message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    return $this->responseBuilder->success('Success! Payment processed', (array) $request);
  }
}
