<?php

namespace App\Constants;

class PaymentGatewayType
{
    public const ACI = 'aci';
    public const SHIFT4 = 'shift4';

    /**
     * Get all payment types.
     *
     * @return array
     */

    public static function get(): array
    {
      return [
        self::ACI,
        self::SHIFT4,
      ];
    }
}
