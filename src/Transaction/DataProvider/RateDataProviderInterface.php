<?php

declare(strict_types=1);

namespace App\Transaction\DataProvider;

/**
 * Interface: rate data provider.
 */
interface RateDataProviderInterface
{
    /**
     * Retrieves currency based exchange rates data.
     *
     * @return array Rates data
     */
    public function getRates(): array;
}
