<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Model\CreateShipment\RequestType;

/**
 * ShipmentNotificationType
 *
 * @author  Rico Sonntag <rico.sonntag@netresearch.de>
 * @link    https://www.netresearch.de/
 */
class ShipmentNotificationType
{
    /**
     * Email address of the recipient. Mandatory if Notification is set.
     *
     * @var string $recipientEmailAddress
     */
    protected $recipientEmailAddress;

    /**
     * @param string $recipientEmailAddress
     */
    public function __construct(string $recipientEmailAddress)
    {
        $this->recipientEmailAddress = $recipientEmailAddress;
    }
}
