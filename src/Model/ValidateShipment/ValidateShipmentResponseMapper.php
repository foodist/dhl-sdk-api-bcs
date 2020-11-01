<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Model\ValidateShipment;

use Dhl\Sdk\Paket\Bcs\Model\ValidateShipment\ResponseType\ValidationState;

class ValidateShipmentResponseMapper
{
    /**
     * @param ValidateShipmentResponse $shipmentResponseType
     * @return ValidationState[]
     */
    public function map(ValidateShipmentResponse $shipmentResponseType): array
    {
        return $shipmentResponseType->getValidationState();
    }
}