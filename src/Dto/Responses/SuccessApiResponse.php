<?php

namespace App\Dto\Responses;

class SuccessApiResponse
{
  public function __construct(
   	public string $message,
   	public array $data = []
  ) {}
}
