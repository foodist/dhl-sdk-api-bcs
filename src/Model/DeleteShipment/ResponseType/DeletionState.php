<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Model\DeleteShipment\ResponseType;

use Dhl\Sdk\Paket\Bcs\Model\Common\StatusInformation;

/**
 * Status of the respective deletion operation.
 *
 * @package Dhl\Sdk\Paket\Bcs\Model\DeleteShipment
 * @author  Rico Sonntag <rico.sonntag@netresearch.de>
 * @license https://choosealicense.com/licenses/mit/ The MIT License
 * @link    https://www.netresearch.de/
 */
class DeletionState
{
    /**
     * Can contain any DHL shipment number.
     *
     * @var string $shipmentNumber
     */
    protected $shipmentNumber;

    /**
     * Success status of processing the deletion of particular shipment.
     *
     * @var StatusInformation $Status
     */
    protected $Status;

    /**
     * @return string
     */
    public function getShipmentNumber(): string
    {
        return $this->shipmentNumber;
    }

    /**
     * @return Statusinformation
     */
    public function getStatus(): StatusInformation
    {
        return $this->Status;
    }
}
