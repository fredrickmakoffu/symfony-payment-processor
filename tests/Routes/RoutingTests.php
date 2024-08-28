<?php

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

it('should route /app/example/shift4 to the correct controller', function () {
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

it('should return 404 for an invalid route', function () {
	$response = $this->client->request('POST', 'http://localhost:8080/app/example/test');
	expect($response->getStatusCode())->toBe(404);
});
