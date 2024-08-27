<?php

namespace App\Services\Validations;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Dto\Request\PaymentRequest;
use Symfony\Component\Validator\ConstraintViolationList;
use App\Contracts\Validations\ValidationServiceInterface;

class PaymentValidationService implements ValidationServiceInterface
{
	private PaymentRequest $paymentRequest;
	private array $data;
	private ConstraintViolationList $errors;

	/**
	 * PaymentValidationService constructor.
	 *
	 */
	public function __construct(private ValidatorInterface $validator)
	{
		$this->data = [];
		$this->errors = new ConstraintViolationList();
		$this->paymentRequest = new PaymentRequest();
	}

	/**
	 * Validate the PaymentRequest DTO
	 * @param array $data
	 * @return ConstraintViolationList
	 */
	public function handle(array $data): ConstraintViolationList
	{
		// set data
		if( !count($this->data)) {
			$this->setData($data);
		}

		// build the PaymentRequest DTO
		$this->build();

		// validate the PaymentRequest DTO
		return $this->validate();
	}

	/**
	 * Set data
	 *
	 * @return PaymentValidationService
	 */
	private function setData(array $data): PaymentValidationService
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * Set errors
	 *
	 * @return PaymentValidationService
	 */
	private function setErrors(ConstraintViolationList $errors): PaymentValidationService
	{
		$this->errors = $errors;
		return $this;
	}

	/**
	 * Validate the PaymentRequest DTO
	 *
	 * @return ConstraintViolationList
	 */

	public function validate(): ConstraintViolationList
	{
		// Validate the PaymentRequest DTO
		$errors = $this->validator->validate($this->paymentRequest);

		// set errors
		$this->setErrors($errors);

		// return errors
		return $this->errors;
	}

	/**
	 * Build the PaymentRequest DTO from the input data
	 *
	 * @return self
	 */
	public function build(): self
	{
		// Retrieve the input arguments
		$this->paymentRequest->amount = $this->data['amount'] ?? null;
		$this->paymentRequest->currency = $this->data['currency'] ?? null;
		$this->paymentRequest->cardNumber = $this->data['cardNumber'] ?? null;
		$this->paymentRequest->cardExpYear = $this->data['cardExpYear'] ?? null;
		$this->paymentRequest->cardExpMonth = $this->data['cardExpMonth'] ?? null;
		$this->paymentRequest->cardCvv = $this->data['cardCvv'] ?? null;

		return $this;
	}

	/**
	 * Get PaymentRequest DTO
	 *
	 * @return object
	 */
	public function getValidatedDto(): object
	{
		return $this->paymentRequest;
	}

	/**
	 * Get errors
	 *
	 * @return ConstraintViolationList
	 */

	public function getErrors(): ConstraintViolationList
	{
		return $this->errors;
	}
}
