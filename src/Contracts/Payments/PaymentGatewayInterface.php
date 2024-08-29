<?php

namespace App\Contracts\Payments;

use App\Dto\Requests\PaymentRequest;
use App\Dto\Responses\PaymentResponse;

interface PaymentGatewayInterface
{
	/**
	 * Process the payment
	 *
	 * @param PaymentRequest $paymentRequest
	 * @return PaymentResponse
	 */

	public function process(PaymentRequest $paymentRequest): PaymentResponse;

	/**
	 * Parse request before submitting to payment processor
	 *
	 * @param PaymentRequest $paymentRequest
	 * @return array
	 */

	public function parseRequest(PaymentRequest $paymentRequest): array;

	/**
	 * Format the response from payment processor
	 *
	 * @param array $response
	 * @return mixed
	 */

	public function formatResponse(array $response): mixed;
}
