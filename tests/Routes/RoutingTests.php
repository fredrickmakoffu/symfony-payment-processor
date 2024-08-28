<?php

use App\Dto\Responses\PaymentResponse;
use Symfony\Component\HttpClient\HttpClient;

beforeEach(function () {
  $this->client = HttpClient::create();
});

it('should route /app/example/aci to the correct controller', function () {
	$data = [
	  "currency" => "EUR",
	  "cardNumber" => "4200000000000000",
	  "cardExpYear" => "2034",
	  "cardExpMonth" => "05",
	  "cardCvv" => "123",
	  "amount" => "92.00"
	];

	$response = $this->client->request('POST', 'http://localhost:8080/app/example/aci', [
		'json' => $data,
	]);

	expect($response->getStatusCode())->toBe(200);
});

it('should produce data in the format of the PaymentResponse DTO', function () {
	$data = [
	  "currency" => "EUR",
	  "cardNumber" => "4200000000000000",
	  "cardExpYear" => "2034",
	  "cardExpMonth" => "05",
	  "cardCvv" => "123",
	  "amount" => "92.00"
	];

	$response = $this->client->request('POST', 'http://localhost:8080/app/example/aci', [
		'json' => $data,
	]);

	$paymentResponse = json_decode($response->getContent(), true);

	$paymentResponse = new PaymentResponse();

	// check if the response is in the correct format
	expect($paymentResponse)->toBeInstanceOf(PaymentResponse::class);
});

it('ACI Service should route /app/example/shift4 to the correct controller', function () {
	$data =  [
	  "currency" => "EUR",
	  "cardNumber" => "card_TvVDIl7qipdWOCRC0xXRiF0K",
	  "cardExpYear" => "2034",
	  "cardExpMonth" => "05",
	  "cardCvv" => "123",
	  "amount" => "92.00"
	];

	$response = $this->client->request('POST', 'http://localhost:8080/app/example/shift4', [
		'json' => $data,
	]);

	expect($response->getStatusCode())->toBe(200);
});

it('Shift4 Service should produce data in the format of the PaymentResponse DTO', function () {
	$data =  [
	  "currency" => "EUR",
	  "cardNumber" => "card_TvVDIl7qipdWOCRC0xXRiF0K",
	  "cardExpYear" => "2034",
	  "cardExpMonth" => "05",
	  "cardCvv" => "123",
	  "amount" => "92.00"
	];

	$response = $this->client->request('POST', 'http://localhost:8080/app/example/shift4', [
		'json' => $data,
	]);

	$paymentResponse = json_decode($response->getContent(), true);

	$paymentResponse = new PaymentResponse();

	// check if the response is in the correct format
	expect($paymentResponse)->toBeInstanceOf(PaymentResponse::class);
});

it('should return 404 for an invalid route', function () {
	$response = $this->client->request('POST', 'http://localhost:8080/app/example/test');
	expect($response->getStatusCode())->toBe(404);
});
