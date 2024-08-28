<?php

use App\Services\Validations\PaymentValidationService;
use App\Contracts\Validations\ValidationServiceInterface;
use Symfony\Component\Validator\Validation;

beforeEach(function () {
  $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
  $this->paymentValidationService = new PaymentValidationService($this->validator);
});

it('validates a correct payment request successfully', function () {
    $data = [
        'amount' => 100,
        'currency' => 'USD',
        'cardNumber' => '4111111111111111',
        'cardExpMonth' => '12',
        'cardExpYear' => '2024',
        'cardCvv' => '123'
    ];

    $errors = $this->paymentValidationService->handle($data);
    expect(count($errors))->toBe(0);
});

it('fails validation for an incorrect payment request', function () {
    $data = [
        'amount' => -100, // Invalid amount (negative)
        'currency' => '', // Invalid currency (empty)
        'cardNumber' => 'invalid', // Invalid card number
        'cardExpMonth' => '13', // Invalid month (greater than 12)
        'cardExpYear' => '2020', // Invalid year (past year)
        'cardCvv' => '12' // Invalid CVV (too short)
    ];

    $errors = $this->paymentValidationService->handle($data);

    expect(count($errors))->toBeGreaterThan(2);
});
