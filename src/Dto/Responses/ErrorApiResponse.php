<?php

namespace App\Dto\Responses;

class ErrorApiResponse
{
  public function __construct(
  	public string $message, // error message here
   	public array $errors, // eg. validation errors passed here as array
    public array $trace = [] // provide trace if required. by default null
  ) {}
}
