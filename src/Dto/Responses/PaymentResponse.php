<?php

namespace App\Dto\Responses;

class PaymentResponse
{
	public string $transaction_id;

	public string $created_at;

	public float $amount;

	public string $currency;

	public string $card_bin;
}
