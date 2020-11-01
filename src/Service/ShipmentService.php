<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Service;

use Dhl\Sdk\Paket\Bcs\Api\Data\ShipmentInterface;
use Dhl\Sdk\Paket\Bcs\Api\ShipmentServiceInterface;
use Dhl\Sdk\Paket\Bcs\Exception\AuthenticationErrorException;
use Dhl\Sdk\Paket\Bcs\Exception\AuthenticationException;
use Dhl\Sdk\Paket\Bcs\Exception\DetailedErrorException;
use Dhl\Sdk\Paket\Bcs\Exception\DetailedServiceException;
use Dhl\Sdk\Paket\Bcs\Exception\ServiceException;
use Dhl\Sdk\Paket\Bcs\Exception\ServiceExceptionFactory;
use Dhl\Sdk\Paket\Bcs\Model\Common\Version;
use Dhl\Sdk\Paket\Bcs\Model\CreateShipment\CreateShipmentOrderRequest;
use Dhl\Sdk\Paket\Bcs\Model\CreateShipment\CreateShipmentResponseMapper;
use Dhl\Sdk\Paket\Bcs\Model\DeleteShipment\DeleteShipmentOrderRequest;
use Dhl\Sdk\Paket\Bcs\Model\DeleteShipment\DeleteShipmentResponseMapper;
use Dhl\Sdk\Paket\Bcs\Model\ValidateShipment\ValidateShipmentOrderRequest;
use Dhl\Sdk\Paket\Bcs\Model\ValidateShipment\ValidateShipmentResponseMapper;
use Dhl\Sdk\Paket\Bcs\Soap\AbstractClient;

/**
 * ShipmentService
 *
 * @author  Rico Sonntag <rico.sonntag@netresearch.de>
 * @link    https://www.netresearch.de/
 */
class ShipmentService implements ShipmentServiceInterface
{
    /**
     * @var AbstractClient
     */
    private $client;

    /**
     * @var CreateShipmentResponseMapper
     */
    private $createShipmentResponseMapper;

    /**
     * @var DeleteShipmentResponseMapper
     */
    private $deleteShipmentResponseMapper;

    /**
     * @var ValidateShipmentResponseMapper
     */
    private $validateShipmentResponseMapper;

    /**
     * ShipmentService constructor.
     *
     * @param AbstractClient $client
     * @param CreateShipmentResponseMapper $createShipmentResponseMapper
     * @param DeleteShipmentResponseMapper $deleteShipmentResponseMapper
     * @param ValidateShipmentResponseMapper $validateShipmentResponseMapper
     */
    public function __construct(
        AbstractClient $client,
        CreateShipmentResponseMapper $createShipmentResponseMapper,
        DeleteShipmentResponseMapper $deleteShipmentResponseMapper,
        ValidateShipmentResponseMapper $validateShipmentResponseMapper
    ) {
        $this->client = $client;
        $this->createShipmentResponseMapper = $createShipmentResponseMapper;
        $this->deleteShipmentResponseMapper = $deleteShipmentResponseMapper;
        $this->validateShipmentResponseMapper = $validateShipmentResponseMapper;
    }

    public function createShipments(array $shipmentOrders): array
    {
        try {
            $version = new Version('3', '0');
            $createShipmentRequest = new CreateShipmentOrderRequest($version, array_values($shipmentOrders));
            $createShipmentRequest->setLabelResponseType('B64');

            $shipmentResponse = $this->client->createShipmentOrder($createShipmentRequest);
            return $this->createShipmentResponseMapper->map($shipmentResponse);
        } catch (AuthenticationErrorException $exception) {
            throw ServiceExceptionFactory::createAuthenticationException($exception);
        } catch (DetailedErrorException $exception) {
            throw ServiceExceptionFactory::createDetailedServiceException($exception);
        } catch (\Throwable $exception) {
            // Catch all leftovers, e.g. \SoapFault, \Exception, ...
            throw ServiceExceptionFactory::createServiceException($exception);
        }
    }

    public function cancelShipments(array $shipmentNumbers): array
    {
        try {
            $version = new Version('3', '0');
            $deleteShipmentRequest = new DeleteShipmentOrderRequest($version, $shipmentNumbers);

            $shipmentResponse = $this->client->deleteShipmentOrder($deleteShipmentRequest);
            return $this->deleteShipmentResponseMapper->map($shipmentResponse);
        } catch (AuthenticationErrorException $exception) {
            throw ServiceExceptionFactory::createAuthenticationException($exception);
        } catch (DetailedErrorException $exception) {
            throw ServiceExceptionFactory::createDetailedServiceException($exception);
        } catch (\Throwable $exception) {
            // Catch all leftovers, e.g. \SoapFault, \Exception, ...
            throw ServiceExceptionFactory::createServiceException($exception);
        }
    }

    public function validateShipments(array $shipmentOrders): array
    {
        try {
            $version = new Version('3', '0');
            $validateShipmentRequest = new ValidateShipmentOrderRequest($version, array_values($shipmentOrders));

            $shipmentResponse = $this->client->validateShipment($validateShipmentRequest);
            return $this->validateShipmentResponseMapper->map($shipmentResponse);
        } catch (AuthenticationErrorException $exception) {
            throw ServiceExceptionFactory::createAuthenticationException($exception);
        } catch (DetailedErrorException $exception) {
            throw ServiceExceptionFactory::createDetailedServiceException($exception);
        } catch (\Throwable $exception) {
            // Catch all leftovers, e.g. \SoapFault, \Exception, ...
            throw ServiceExceptionFactory::createServiceException($exception);
        }
    }
}
