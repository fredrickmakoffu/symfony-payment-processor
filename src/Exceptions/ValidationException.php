<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationException extends Exception
{
  private $errors;

  public function __construct(
  	ConstraintViolationList $errors,
  	string $message = "We have found some errors with the data you have submitted",
    int $code = 0,
    Exception $previous = null
  )
  {
    parent::__construct($message, $code, $previous);
    $this->errors = $errors;
  }

  /**
    * Get the validation errors.
    *
    * @return array
    */
  public function getErrors(): array
  {
  	$formattedErrors = [];

	  foreach ($this->errors as $error) {
	      $formattedErrors[] = [
	          'field' => $error->getPropertyPath(),
	          'message' => $error->getMessage(),
	      ];
	  }

	  return $formattedErrors;
  }

  public function getValidationMessage(): string
  {
  	return $this->message;
  }
}
