<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
  private $errors;

  public function __construct(
  	array $errors = [],
  	string $message = 'We\'ve found some errors with the data you\'ve submitted',
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
    return $this->errors;
  }

  public function getValidationMessage(): string
  {
  	return $this->message;
  }
}
