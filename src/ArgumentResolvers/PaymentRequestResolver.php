<?php

namespace App\ArgumentResolvers;

use App\Dto\Request\PaymentRequest;
use App\Exceptions\ValidationException;
use App\Services\Responses\ApiResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentRequestResolver implements ArgumentValueResolverInterface
{
  public function __construct(private ApiResponseBuilder $responseBuilder, private ValidatorInterface $validator)
  {}

  public function supports(Request $request, ArgumentMetadata $argument): bool
  {
      return $argument->getType() === PaymentRequest::class;
  }

  public function resolve(Request $request, ArgumentMetadata $argument): iterable
  {
	  // Create a PaymentRequest DTO from the request
	  $paymentRequest = new PaymentRequest();
	  $paymentRequest->amount = $request->query->get('amount');
	  $paymentRequest->currency = $request->query->get('currency');
	  $paymentRequest->cardNumber = $request->query->get('cardNumber');
	  $paymentRequest->cardExpYear = $request->query->get('cardExpYear');
	  $paymentRequest->cardExpMonth = $request->query->get('cardExpMonth');
	  $paymentRequest->cardCvv = $request->query->get('cardCvv');

	  // Validate the PaymentRequest DTO
	  $errors = $this->validator->validate($paymentRequest);

	  // If there are validation errors, throw an exception
	  if (count($errors) > 0) throw new ValidationException($errors);

		yield $paymentRequest;
  }
}
