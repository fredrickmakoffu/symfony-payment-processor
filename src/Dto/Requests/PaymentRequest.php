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
    #[Assert\Type(type: 'integer')]
    #[Assert\Length(min: 16, max: 16)]
    public ?int $cardNumber;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[Assert\Length(min: 4, max: 4)]
    public ?int $cardExpYear;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[Assert\Length(min: 2, max: 2)]
    public ?int $cardExpMonth;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[Assert\Length(min: 3, max: 3)]
    public ?int $cardCvv;
}
