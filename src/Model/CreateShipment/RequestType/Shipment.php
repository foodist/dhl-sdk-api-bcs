<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Model\CreateShipment\RequestType;

/**
 * Shipment
 *
 * @package Dhl\Sdk\Paket\Bcs\Model\CreateShipment
 * @author  Rico Sonntag <rico.sonntag@netresearch.de>
 * @license https://choosealicense.com/licenses/mit/ The MIT License
 * @link    https://www.netresearch.de/
 */
class Shipment
{
    /**
     * Contains the information of the shipment product code, weight and size characteristics and services to be used.
     *
     * @var ShipmentDetailsTypeType $ShipmentDetails
     */
    protected $ShipmentDetails;

    /**
     * Contains relevant information about Receiver.
     *
     * @var ReceiverType $Receiver
     */
    protected $Receiver;

    /**
     * Contains relevant information about the Shipper.
     *
     * @var ShipperType $Shipper
     */
    protected $Shipper;

    /**
     * To be used if a return label address shall be generated.
     *
     * @var ShipperType|null $ReturnReceiver
     */
    protected $ReturnReceiver = null;

    /**
     * For international shipments, this section contains information about the exported goods relevant for customs.
     *
     * @var ExportDocumentType|null $ExportDocument
     */
    protected $ExportDocument = null;

    /**
     * Contains a reference to the Shipper data configured in GKP.
     *
     * @var string|null
     */
    protected $ShipperReference = null;

    /**
     * @param ShipmentDetailsTypeType $shipmentDetails
     * @param ReceiverType $receiver
     * @param ShipperType $shipper Conditionally mandatory. If omitted, set ShipperReference instead.
     */
    public function __construct(
        ShipmentDetailsTypeType $shipmentDetails,
        ReceiverType $receiver,
        ShipperType $shipper = null
    ) {
        $this->ShipmentDetails = $shipmentDetails;
        $this->Receiver = $receiver;
        $this->Shipper = $shipper;
    }

    /**
     * @param ShipperType $returnReceiver
     * @return Shipment
     */
    public function setReturnReceiver(ShipperType $returnReceiver): self
    {
        $this->ReturnReceiver = $returnReceiver;
        return $this;
    }

    /**
     * @param ExportDocumentType $exportDocument
     * @return Shipment
     */
    public function setExportDocument(ExportDocumentType $exportDocument): self
    {
        $this->ExportDocument = $exportDocument;
        return $this;
    }

    /**
     * @param string $shipperReference
     * @return Shipment
     */
    public function setShipperReference(string $shipperReference): self
    {
        $this->ShipperReference = $shipperReference;
        return $this;
    }
}