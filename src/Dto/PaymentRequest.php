<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class PaymentRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
		 * @Assert\Type(type="float")
     * @Assert\Positive()
     */
    public $amount;

    /**
     * @Assert\NotBlank()
     * @Assert\Currency()
     */
    public $currency;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d{16}$/")
     */
    public $cardNumber;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d{4}$/")
     * @Assert\GreaterThanOrEqual(value=2024)
     */
    public $cardExpYear;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d{2}$/")
     * @Assert\Range(min=1, max=12)
     */
    public $cardExpMonth;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d{3}$/")
     */
    public $cardCvv;
}
