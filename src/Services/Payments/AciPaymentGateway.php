<?php

namespace App\Services\Payments;

use App\Contracts\Payments\PaymentGatewayInterface;
use App\Dto\Requests\PaymentRequest;
use App\Dto\Responses\PaymentResponse;
use App\Services\Helpers\HttpRequestServices;

class AciPaymentGateway implements PaymentGatewayInterface
{
	protected object $card_details;
	protected string $aci_entity_id, $aci_authorization, $aci_api_url;

	/**
	 * Constructor
	 *
	 * @param HttpRequestServices $httpRequestServices
	 */
	public function __construct(private HttpRequestServices $httpRequestServices)
	{
		$this->aci_entity_id = $_ENV['ACI_ENTITY_ID'];
		$this->aci_authorization = $_ENV['ACI_AUTHORIZATION'];
		$this->aci_api_url = $_ENV['ACI_API_URL'];

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
      "Authorization: Bearer " . $this->aci_authorization
	  ];

		// set optional parameters
		$options = [
			'verify_peer' => false,
		];

		// send the request to ACI API
		$response = $this->httpRequestServices->post($this->aci_api_url, $aci_request, $headers, $options);

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
      "entityId" => $this->aci_entity_id,
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
