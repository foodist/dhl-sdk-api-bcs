<?php
/**
 * See LICENSE.md for license details.
 */
declare(strict_types=1);

namespace Dhl\Sdk\Paket\Bcs\Api\Data;

/**
 * Interface AuthenticationStorageInterface
 *
 * @api
 * @author  Christoph Aßmann <christoph.assmann@netresearch.de>
 * @link    https://www.netresearch.de/
 */
interface AuthenticationStorageInterface
{
    /**
     * @return string
     */
    public function getApplicationId(): string;

    /**
     * @return string
     */
    public function getApplicationToken(): string;

    /**
     * @return string
     */
    public function getUser(): string;

    /**
     * @return string
     */
    public function getSignature(): string;
}
