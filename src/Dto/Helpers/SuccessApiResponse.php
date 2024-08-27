<?php

namespace App\Dto\Helpers;

class SuccessApiResponse
{
  public function __construct(
   	public string $message,
   	public array $data = []
  ) {}
}
