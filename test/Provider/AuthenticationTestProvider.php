<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Test\Provider;

/**
 * Class AuthenticationTestProvider
 *
 * @package Dhl\Sdk\Paket\Bcs\Test
 * @author  Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link    https://www.netresearch.de/
 */
class AuthenticationTestProvider
{
    /**
     * Provide request and response for the test case
     * - invalid app credentials sent to the API, soap fault thrown.
     *
     * @return mixed[]
     */
    public static function appAuthFailure()
    {
        $wsdl = __DIR__ . '/_files/gvapi-3.0/geschaeftskundenversand-api-3.0.wsdl';
        $authStorage = AuthenticationStorageProvider::appAuthFailure();
        $shipmentOrders = ShipmentRequestProvider::createSingleShipmentSuccess();
        $soapFault = new \SoapFault('HTTP', 'Unauthorized');

        return [
            'application auth error' => [$wsdl, $authStorage, $shipmentOrders, $soapFault],
        ];
    }

    /**
     * Provide request and response for the test case
     * - invalid user credentials sent to the API, error returned.
     *
     * @return mixed[]
     */
    public static function userAuthFailure()
    {
        $wsdl = __DIR__ . '/_files/gvapi-3.0/geschaeftskundenversand-api-3.0.wsdl';
        $authStorage = AuthenticationStorageProvider::userAuthFailure();
        $shipmentOrders = ShipmentRequestProvider::createSingleShipmentSuccess();
        $responseXml = \file_get_contents(__DIR__ . '/_files/auth/passwordExpired.xml');

        return [
            'user auth error' => [$wsdl, $authStorage, $shipmentOrders, $responseXml],
        ];
    }
}