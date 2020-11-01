<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Test\Expectation;

use Dhl\Sdk\Paket\Bcs\Api\Data\ShipmentInterface;
use Dhl\Sdk\Paket\Bcs\Model\ValidateShipment\ResponseType\ValidationState;
use PHPUnit\Framework\Assert;

/**
 * Class ShipmentServiceTestExpectation
 *
 * @author  Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link    https://www.netresearch.de/
 */
class ShipmentServiceTestExpectation
{
    /**
     * @param string $requestXml
     * @param string $responseXml
     * @param ShipmentInterface[] $result
     */
    public static function assertAllShipmentsBooked(string $requestXml, string $responseXml, array $result)
    {
        $request = new \SimpleXMLElement($requestXml);

        $request->registerXPathNamespace('SOAP-ENV', 'http://schemas.xmlsoap.org/soap/envelope/');
        $request->registerXPathNamespace('ns2', 'http://dhl.de/webservices/businesscustomershipping/3.0');
        $request = $request->xpath('/SOAP-ENV:Envelope/SOAP-ENV:Body/ns2:CreateShipmentOrderRequest')[0];

        $response = new \SimpleXMLElement($responseXml);
        $response->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $response->registerXPathNamespace('bcs', 'http://dhl.de/webservices/businesscustomershipping/3.0');
        $response = $response->xpath('/soap:Envelope/soap:Body/bcs:CreateShipmentOrderResponse')[0];

        // assert that all sequence numbers of the request are available in the response
        $expected = $request->xpath('./ShipmentOrder/sequenceNumber');
        $actual = array_map(function (ShipmentInterface $shipment) {
            return $shipment->getSequenceNumber();
        }, $result);
        Assert::assertEmpty(array_diff($expected, $actual), 'Sequence numbers of the response do not match.');

        // assert that all labels are included in the response
        foreach ($result as $shipment) {
            $sn = $shipment->getSequenceNumber();
            $labelData = $response->xpath("./CreationState[sequenceNumber=$sn]/LabelData")[0];
            $expected = $labelData->xpath("./*[substring(name(), string-length(name()) - 3) = 'Data']");
            $actual = array_filter($shipment->getLabels());
            Assert::assertEmpty(array_diff($expected, $actual), "Returned labels are not mapped to result for $sn.");
        }
    }

    /**
     * @param string $requestXml
     * @param string $responseXml
     * @param ShipmentInterface[] $result
     */
    public static function assertSomeShipmentsBooked(string $requestXml, string $responseXml, array $result)
    {
        $request = new \SimpleXMLElement($requestXml);

        $request->registerXPathNamespace('SOAP-ENV', 'http://schemas.xmlsoap.org/soap/envelope/');
        $request->registerXPathNamespace('ns2', 'http://dhl.de/webservices/businesscustomershipping/3.0');
        $request = $request->xpath('/SOAP-ENV:Envelope/SOAP-ENV:Body/ns2:CreateShipmentOrderRequest')[0];

        $response = new \SimpleXMLElement($responseXml);
        $response->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $response->registerXPathNamespace('bcs', 'http://dhl.de/webservices/businesscustomershipping/3.0');
        $response = $response->xpath('/soap:Envelope/soap:Body/bcs:CreateShipmentOrderResponse')[0];

        // assert that all sequence numbers of the request are available in the response
        $expected = $request->xpath('./ShipmentOrder/sequenceNumber');
        $actual = $response->xpath('./CreationState/sequenceNumber');
        Assert::assertEmpty(array_diff($expected, $actual), 'Sequence numbers of the response do not match.');

        // assert that success and error status are contained in the response
        $labels = $response->xpath("./CreationState/LabelData[./Status/statusCode = '0']");
        $errors = $response->xpath("./CreationState/LabelData[./Status/statusCode != '0']");
        Assert::assertCount(count($expected), array_merge($labels, $errors));

        // assert that shipments were created but not all of them
        Assert::assertNotEmpty($result);
        Assert::assertLessThan(count($expected), count($result));
    }

    /**
     * @param string $requestXml
     * @param string[] $result
     */
    public static function assertAllShipmentsCancelled(string $requestXml, array $result)
    {
        $request = new \SimpleXMLElement($requestXml);

        $request->registerXPathNamespace('SOAP-ENV', 'http://schemas.xmlsoap.org/soap/envelope/');
        $request->registerXPathNamespace('ns1', 'http://dhl.de/webservice/cisbase');
        $request->registerXPathNamespace('ns2', 'http://dhl.de/webservices/businesscustomershipping/3.0');
        $request = $request->xpath('/SOAP-ENV:Envelope/SOAP-ENV:Body/ns2:DeleteShipmentOrderRequest')[0];

        // assert that all shipment numbers of the request are available in the response
        $expected = $request->xpath('./shipmentNumber');
        Assert::assertEmpty(array_diff($expected, $result), 'Shipment numbers of the response do not match.');
    }

    /**
     * @param string $requestXml
     * @param string $responseXml
     * @param string[] $result
     */
    public static function assertSomeShipmentsCancelled(string $requestXml, string $responseXml, array $result)
    {
        $request = new \SimpleXMLElement($requestXml);

        $request->registerXPathNamespace('SOAP-ENV', 'http://schemas.xmlsoap.org/soap/envelope/');
        $request->registerXPathNamespace('ns1', 'http://dhl.de/webservice/cisbase');
        $request->registerXPathNamespace('ns2', 'http://dhl.de/webservices/businesscustomershipping/3.0');
        $request = $request->xpath('/SOAP-ENV:Envelope/SOAP-ENV:Body/ns2:DeleteShipmentOrderRequest')[0];

        $response = new \SimpleXMLElement($responseXml);
        $response->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $response->registerXPathNamespace('bcs', 'http://dhl.de/webservices/businesscustomershipping/3.0');
        $response->registerXPathNamespace('cis', 'http://dhl.de/webservice/cisbase');
        $response = $response->xpath('/soap:Envelope/soap:Body/bcs:DeleteShipmentOrderResponse')[0];

        // assert that all shipment numbers of the request are available in the response
        $expected = $request->xpath('./ns1:shipmentNumber');
        $actual = $response->xpath('./DeletionState/cis:shipmentNumber');
        Assert::assertEmpty(array_diff($expected, $actual), 'Shipment numbers of the response do not match.');

        // assert that success and error status are contained in the response
        $cancelled = $response->xpath("./DeletionState/Status[./statusCode = '0']");
        $failed = $response->xpath("./DeletionState/Status[./statusCode != '0']");
        Assert::assertCount(count($expected), array_merge($cancelled, $failed));

        // assert that shipments were cancelled but not all of them
        Assert::assertNotEmpty($result);
        Assert::assertLessThan(count($expected), count($result));
    }

    /**
     * @param string $requestXml
     * @param string $responseXml
     * @param ValidationState[] $result
     */
    public static function assertAllShipmentsValid(string $requestXml, string $responseXml, array $result)
    {
        $request = new \SimpleXMLElement($requestXml);

        $request->registerXPathNamespace('SOAP-ENV', 'http://schemas.xmlsoap.org/soap/envelope/');
        $request->registerXPathNamespace('ns2', 'http://dhl.de/webservices/businesscustomershipping/3.0');
        $request = $request->xpath('/SOAP-ENV:Envelope/SOAP-ENV:Body/ns2:ValidateShipmentOrderRequest')[0];

        $response = new \SimpleXMLElement($responseXml);
        $response->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $response->registerXPathNamespace('bcs', 'http://dhl.de/webservices/businesscustomershipping/3.0');
        $response = $response->xpath('/soap:Envelope/soap:Body/bcs:ValidateShipmentResponse')[0];

        // assert that all sequence numbers of the request are available in the response
        $expected = $request->xpath('./ShipmentOrder/sequenceNumber');
        $actual = $response->xpath('./ValidationState/sequenceNumber');
        Assert::assertEmpty(array_diff($expected, $actual), 'Sequence numbers of the response do not match.');

        // assert that success and error status are contained in the response
        // assert that shipments are valid
        $status = $response->xpath("./ValidationState[./Status/statusCode = '0']");
        Assert::assertNotEmpty($result);
        Assert::assertCount(count($expected), $status);
    }

    /**
     * @param string $requestXml
     * @param string $responseXml
     * @param ValidationState[] $result
     */
    public static function assertSomeShipmentsValid(string $requestXml, string $responseXml, array $result)
    {
        $request = new \SimpleXMLElement($requestXml);

        $request->registerXPathNamespace('SOAP-ENV', 'http://schemas.xmlsoap.org/soap/envelope/');
        $request->registerXPathNamespace('ns2', 'http://dhl.de/webservices/businesscustomershipping/3.0');
        $request = $request->xpath('/SOAP-ENV:Envelope/SOAP-ENV:Body/ns2:ValidateShipmentOrderRequest')[0];

        $response = new \SimpleXMLElement($responseXml);
        $response->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $response->registerXPathNamespace('bcs', 'http://dhl.de/webservices/businesscustomershipping/3.0');
        $response = $response->xpath('/soap:Envelope/soap:Body/bcs:ValidateShipmentResponse')[0];

        // assert that all sequence numbers of the request are available in the response
        $expected = $request->xpath('./ShipmentOrder/sequenceNumber');
        $actual = $response->xpath('./ValidationState/sequenceNumber');
        Assert::assertEmpty(array_diff($expected, $actual), 'Sequence numbers of the response do not match.');

        // assert that success and error status are contained in the response
        $success = $response->xpath("./ValidationState[./Status/statusCode = '0']");
        $errors = $response->xpath("./ValidationState[./Status/statusCode != '0']");
        Assert::assertCount(count($expected), array_merge($success, $errors));

        // assert that shipments were validated but not all of them are valid
        Assert::assertNotEmpty($result);
        Assert::assertLessThan(count($expected), count($success));
    }
}
