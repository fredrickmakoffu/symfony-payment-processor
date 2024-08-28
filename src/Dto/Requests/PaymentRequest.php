<?php

namespace App\Dto\Request;
use Symfony\Component\Validator\Constraints as Assert;

class PaymentRequest
{
	 	#[Assert\NotBlank]
		#[Assert\Type(type: 'float')]
		#[Assert\Positive]

    public ?float $amount;

    #[Assert\NotBlank]

    public ?string $currency;

    #[Assert\NotBlank]

    public int|string|null $cardNumber;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[Assert\Length(min: 4, max: 4)]

    public ?int $cardExpYear;

    #[Assert\NotBlank]

    public ?string $cardExpMonth;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[Assert\Length(min: 3, max: 3)]

    public ?int $cardCvv;
}
