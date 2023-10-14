<?php

declare(strict_types=1);

namespace App\Transaction\Exchanger;

/**
 * Interface: currency based rate provider.
 */
interface CurrencyBasedExchangerInterface
{
    /**
     * Retrieves currency based exchange rate for given currency.
     *
     * @param string $currency Currency
     * @return float Exchange rate for given currency
     */
    public function getRate(string $currency): float;
}
