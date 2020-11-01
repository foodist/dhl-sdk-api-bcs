<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Soap;

use Dhl\Sdk\Paket\Bcs\Model\CreateShipment\CreateShipmentOrderRequest;
use Dhl\Sdk\Paket\Bcs\Model\CreateShipment\CreateShipmentOrderResponse;
use Dhl\Sdk\Paket\Bcs\Model\DeleteShipment\DeleteShipmentOrderRequest;
use Dhl\Sdk\Paket\Bcs\Model\DeleteShipment\DeleteShipmentOrderResponse;
use Dhl\Sdk\Paket\Bcs\Model\ValidateShipment\ValidateShipmentOrderRequest;
use Dhl\Sdk\Paket\Bcs\Model\ValidateShipment\ValidateShipmentResponse;

/**
 * Class Client
 *
 * @author Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link   https://www.netresearch.de/
 */
class Client extends AbstractClient
{
    /**
     * @var \SoapClient
     */
    private $soapClient;

    /**
     * Client constructor.
     * @param \SoapClient $soapClient
     */
    public function __construct(\SoapClient $soapClient)
    {
        $this->soapClient = $soapClient;
    }

    /**
     * CreateShipmentOrder is the operation call used to generate shipments with the relevant DHL Paket labels.
     *
     * @param CreateShipmentOrderRequest $requestType
     *
     * @return CreateShipmentOrderResponse
     * @throws \SoapFault
     */
    public function createShipmentOrder(CreateShipmentOrderRequest $requestType): CreateShipmentOrderResponse
    {
        /** @var CreateShipmentOrderResponse $response */
        $response = $this->soapClient->__soapCall(__FUNCTION__, [$requestType]);

        return $response;
    }

    /**
     * @param DeleteShipmentOrderRequest $requestType
     *
     * @return DeleteShipmentOrderResponse
     * @throws \SoapFault
     */
    public function deleteShipmentOrder(DeleteShipmentOrderRequest $requestType): DeleteShipmentOrderResponse
    {
        /** @var DeleteShipmentOrderResponse $response */
        $response = $this->soapClient->__soapCall(__FUNCTION__, [$requestType]);

        return $response;
    }

    /**
     * @param ValidateShipmentOrderRequest $requestType
     *
     * @return ValidateShipmentResponse
     * @throws \SoapFault
     */
    public function validateShipment(ValidateShipmentOrderRequest $requestType): ValidateShipmentResponse
    {
        /** @var ValidateShipmentResponse $response */
        $response = $this->soapClient->__soapCall(__FUNCTION__, [$requestType]);

        return $response;
    }
}
