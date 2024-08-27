<?php

namespace App\Services\Payments;

use App\Contracts\Payments\PaymentsProcessingInterface;
use App\Dto\Request\PaymentRequest;
use App\Dto\Responses\PaymentResponse;
use App\Services\Helpers\HttpRequestServices;

class AciPaymentProcessingService implements PaymentsProcessingInterface
{

	const ACI_API_URL = 'https://eu-test.oppwa.com/v1/payments'; // ACI API URL
	const ACI_ENTITY_ID = '8a8294174b7ecb28014b9699220015ca'; // ACI Entity ID
	const ACI_AUTHORIZATION = 'Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';

	protected object $card_details;

	/**
	 * Constructor
	 *
	 * @param HttpRequestServices $httpRequestServices
	 */
	public function __construct(private HttpRequestServices $httpRequestServices)
	{
		$this->card_details = (object) array(
			"payment_brand" => "VISA",
      "payment_type" => "PA",
      "card_holder" => "Jane Jones"
		);
	}

	/**
	 * Process the payment
	 *
	 * @param PaymentRequest $paymentRequest
	 * @return PaymentResponse
	 */
	public function process(PaymentRequest $paymentRequest): PaymentResponse
	{
		// parse the request to ACI API
		$aci_request = $this->parseRequest($paymentRequest);

		// set headers
  	$headers = [
      "Authorization: " . self::ACI_AUTHORIZATION,
	  ];

		// set optional parameters
		$options = [
			'verify_peer' => false,
		];

		// send the request to ACI API
		$response = $this->httpRequestServices->post(trim(self::ACI_API_URL), $aci_request, $headers, $options);

		if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
			$message = $response->getContent(false);
			throw new \Exception('Payment processing failed', $response->getStatusCode());
		}

		// format the response to the required format, PaymentResponse
		$response = $this->formatResponse($response->toArray());

		// return the response
		return $response;
	}

	/**
	 * Parse request to Shift4 API
	 *
	 * @param array $data
	 * @return array
	 */
	public function parseRequest(PaymentRequest $paymentRequest): array
	{
		return array(
			"amount" => $paymentRequest->amount,
      "currency" => $paymentRequest->currency,
      "entityId" => self::ACI_ENTITY_ID,
      "card.number" => $paymentRequest->cardNumber,
      "card.expiryMonth" => $paymentRequest->cardExpMonth,
      "card.expiryYear" => $paymentRequest->cardExpYear,
      "card.cvv" => $paymentRequest->cardCvv,
      "paymentBrand" => $this->card_details->payment_brand,
      "paymentType" => $this->card_details->payment_type,
      "card.holder" => $this->card_details->card_holder
		);
	}

	/**
	 * Format response from Shift4 API
	 *
	 * @param mixed $response
	 * @return mixed
	 */

	public function formatResponse(array $response): PaymentResponse
	{
		$paymentResponse = new PaymentResponse;

		$paymentResponse->transaction_id = $response['id'];
		$paymentResponse->created_at = $response['timestamp'];
		$paymentResponse->amount = $response['amount'];
		$paymentResponse->currency = $response['currency'];
		$paymentResponse->card_bin = $response['card']['bin'];

		return $paymentResponse;
	}
}
