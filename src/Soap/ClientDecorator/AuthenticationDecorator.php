<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Soap\ClientDecorator;

use Dhl\Sdk\Paket\Bcs\Api\Data\AuthenticationStorageInterface;
use Dhl\Sdk\Paket\Bcs\Model\CreateShipment\CreateShipmentOrderRequest;
use Dhl\Sdk\Paket\Bcs\Model\CreateShipment\CreateShipmentOrderResponse;
use Dhl\Sdk\Paket\Bcs\Model\DeleteShipment\DeleteShipmentOrderRequest;
use Dhl\Sdk\Paket\Bcs\Model\DeleteShipment\DeleteShipmentOrderResponse;
use Dhl\Sdk\Paket\Bcs\Model\ValidateShipment\ValidateShipmentOrderRequest;
use Dhl\Sdk\Paket\Bcs\Model\ValidateShipment\ValidateShipmentResponse;
use Dhl\Sdk\Paket\Bcs\Soap\AbstractClient;
use Dhl\Sdk\Paket\Bcs\Soap\AbstractDecorator;

/**
 * AuthenticationDecorator
 *
 * @author  Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link    https://www.netresearch.de/
 */
class AuthenticationDecorator extends AbstractDecorator
{
    /**
     * @var \SoapClient
     */
    private $soapClient;

    /**
     * @var AuthenticationStorageInterface
     */
    private $authStorage;

    /**
     * AuthenticationDecorator constructor.
     * @param AbstractClient $client
     * @param \SoapClient $soapClient
     * @param AuthenticationStorageInterface $authStorage
     */
    public function __construct(
        AbstractClient $client,
        \SoapClient $soapClient,
        AuthenticationStorageInterface $authStorage
    ) {
        $this->soapClient = $soapClient;
        $this->authStorage = $authStorage;

        parent::__construct($client);
    }

    /**
     * @return void
     */
    private function addAuthHeader()
    {
        $authHeader = new \SoapHeader(
            'http://dhl.de/webservice/cisbase',
            'Authentification',
            [
                'user' => $this->authStorage->getUser(),
                'signature' => $this->authStorage->getSignature(),
            ]
        );

        $this->soapClient->__setSoapHeaders([$authHeader]);
    }

    public function createShipmentOrder(CreateShipmentOrderRequest $requestType): CreateShipmentOrderResponse
    {
        $this->addAuthHeader();
        return parent::createShipmentOrder($requestType);
    }

    public function deleteShipmentOrder(DeleteShipmentOrderRequest $requestType): DeleteShipmentOrderResponse
    {
        $this->addAuthHeader();
        return parent::deleteShipmentOrder($requestType);
    }

    public function validateShipment(ValidateShipmentOrderRequest $requestType): ValidateShipmentResponse
    {
        $this->addAuthHeader();
        return parent::validateShipment($requestType);
    }
}
