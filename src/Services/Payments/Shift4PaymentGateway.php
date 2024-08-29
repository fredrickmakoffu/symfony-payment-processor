<?php

namespace App\Services\Payments;

use App\Contracts\Payments\PaymentGatewayInterface;
use App\Dto\Requests\PaymentRequest;
use App\Dto\Responses\PaymentResponse;
use App\Services\Helpers\HttpRequestServices;

class Shift4PaymentGateway implements PaymentGatewayInterface
{
	protected object $card_details;
	protected string $shift4_api_key;
	protected string $shift4_api_url;

	/**
	 * Constructor
	 *
	 * @param HttpRequestServices $httpRequestServices
	 */

	public function __construct(private HttpRequestServices $httpRequestServices)
	{
		$this->shift4_api_key = $_ENV['SHIFT4_API_KEY'];
		$this->shift4_api_url = $_ENV['SHIFT4_API_URL'];

		$this->card_details = (object) array(
			"customer_id" => "cust_eTMHkN8elbg2hsnDENa9EOts",
      "card" => "card_TvVDIl7qipdWOCRC0xXRiF0K",
      "description" => "Payment for order #12345"
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
		$shift4_request = $this->parseRequest($paymentRequest);

		// set headers
  	$options = [
      'auth_basic' => [$this->shift4_api_key, ''],
	  ];

		// send the request to ACI API
		$response = $this->httpRequestServices->post(trim($this->shift4_api_url), $shift4_request, [], $options);

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
      "customerId" => $this->card_details->customer_id,
      "card" => $this->card_details->card,
      "description" => $this->card_details->description
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
		$paymentResponse->created_at = (new \DateTime())->setTimestamp($response['created'])->format('Y-m-d H:i:s');
		$paymentResponse->amount = $response['amount'];
		$paymentResponse->currency = $response['currency'];
		$paymentResponse->card_bin = $response['card']['last4'];

		return $paymentResponse;
	}
}
