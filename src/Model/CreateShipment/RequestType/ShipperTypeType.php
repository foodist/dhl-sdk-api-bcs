<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Model\CreateShipment\RequestType;

/**
 * ShipperTypeType
 *
 * @package Dhl\Sdk\Paket\Bcs\Model\CreateShipment
 * @author  Rico Sonntag <rico.sonntag@netresearch.de>
 * @license https://choosealicense.com/licenses/mit/ The MIT License
 * @link    https://www.netresearch.de/
 */
class ShipperTypeType
{
    /**
     * @var NameType $Name
     */
    protected $Name;

    /**
     * @var NativeAddressType $Address
     */
    protected $Address;

    /**
     * @var CommunicationType|null $Communication
     */
    protected $Communication = null;

    /**
     * @param NameType $name
     * @param NativeAddressType $address
     */
    public function __construct(NameType $name, NativeAddressType $address)
    {
        $this->Name = $name;
        $this->Address = $address;
    }

    /**
     * @param CommunicationType $Communication
     * @return ShipperTypeType
     */
    public function setCommunication(CommunicationType $Communication): self
    {
        $this->Communication = $Communication;
        return $this;
    }
}