<?php

namespace App\ArgumentResolvers;

use App\Dto\Requests\PaymentRequest;
use App\Exceptions\ValidationException;
use App\Services\Responses\ApiResponseBuilder;
use App\Services\Validations\PaymentValidationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentRequestResolver implements ArgumentValueResolverInterface
{
  public function __construct(private ApiResponseBuilder $responseBuilder, private ValidatorInterface $validator, private PaymentValidationService $paymentValidation)
  {}

  public function supports(Request $request, ArgumentMetadata $argument): bool
  {
      return $argument->getType() === PaymentRequest::class;
  }

  public function resolve(Request $request, ArgumentMetadata $argument): iterable
  {
  	// Get the payment data from the request
  	$payment_data = json_decode($request->getContent(), true);

   	// Validate the PaymentRequest DTO
   	$errors = $this->paymentValidation->handle($payment_data);

    // get the payment request
    $paymentRequest = $this->paymentValidation->getValidatedDto();

	  // If there are validation errors, throw an exception
	  if (count($errors) > 0) throw new ValidationException($errors);

		yield $paymentRequest;
  }
}
