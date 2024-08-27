<?php

namespace App\Dto\Responses;

class SuccessApiResponse
{
  public function __construct(
  	public int $status,
   	public string $message,
   	public array $data = []
  ) {}
}
