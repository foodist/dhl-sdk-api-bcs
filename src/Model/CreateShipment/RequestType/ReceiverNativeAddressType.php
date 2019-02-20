<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Model\CreateShipment\RequestType;

/**
 * ReceiverNativeAddressType
 *
 * @package Dhl\Sdk\Paket\Bcs\Model\CreateShipment
 * @author  Rico Sonntag <rico.sonntag@netresearch.de>
 * @license https://choosealicense.com/licenses/mit/ The MIT License
 * @link    https://www.netresearch.de/
 */
class ReceiverNativeAddressType
{
    /**
     * Name of street.
     *
     * @var string $streetName
     */
    protected $streetName;

    /**
     * House number.
     *
     * @var string $streetNumber
     */
    protected $streetNumber;

    /**
     * Type of zip code.
     *
     * @var string $zip
     */
    protected $zip;

    /**
     * City name.
     *
     * @var string $city
     */
    protected $city;

    /**
     * Name of company (second part).
     *
     * @var string|null $name2
     */
    protected $name2 = null;

    /**
     * Name of company (third part).
     *
     * @var string|null $name3
     */
    protected $name3 = null;

    /**
     * Name of company (third part).
     *
     * @var string[] $addressAddition
     */
    protected $addressAddition = [];

    /**
     * Dispatching information.
     *
     * @var string|null $dispatchingInformation
     */
    protected $dispatchingInformation = null;

    /**
     * Province name.
     *
     * @var string|null $province
     */
    protected $province = null;

    /**
     * Country.
     *
     * @var CountryType|null $Origin
     */
    protected $Origin = null;

    /**
     * @param string $streetName
     * @param string $streetNumber
     * @param string $zip
     * @param string $city
     */
    public function __construct(string $streetName, string $streetNumber, string $zip, string $city)
    {
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->zip = $zip;
        $this->city = $city;
    }

    /**
     * @param string $name2
     * @return ReceiverNativeAddressType
     */
    public function setName2(string $name2): self
    {
        $this->name2 = $name2;
        return $this;
    }

    /**
     * @param string $name3
     * @return ReceiverNativeAddressType
     */
    public function setName3(string $name3): self
    {
        $this->name3 = $name3;
        return $this;
    }

    /**
     * @param string $streetName
     * @return ReceiverNativeAddressType
     */
    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;
        return $this;
    }

    /**
     * @param string $streetNumber
     * @return ReceiverNativeAddressType
     */
    public function setStreetNumber(string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    /**
     * @param string[] $addressAddition
     * @return ReceiverNativeAddressType
     */
    public function setAddressAddition(array $addressAddition): self
    {
        $this->addressAddition = $addressAddition;
        return $this;
    }

    /**
     * @param string $dispatchingInformation
     * @return ReceiverNativeAddressType
     */
    public function setDispatchingInformation(string $dispatchingInformation): self
    {
        $this->dispatchingInformation = $dispatchingInformation;
        return $this;
    }

    /**
     * @param string $province
     * @return ReceiverNativeAddressType
     */
    public function setProvince(string $province): self
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @param CountryType $origin
     * @return ReceiverNativeAddressType
     */
    public function setOrigin(CountryType $origin): self
    {
        $this->Origin = $origin;
        return $this;
    }

}