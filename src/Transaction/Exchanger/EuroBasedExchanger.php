<?php

declare(strict_types=1);

namespace App\Transaction\Exchanger;

use App\Transaction\DataProvider\RateDataProviderInterface;
use App\Transaction\Exception\ExchangeRatesMissingException;

/**
 * Rate exchanger with the base in EUR currency.
 */
final class EuroBasedExchanger implements CurrencyBasedExchangerInterface
{
    /**
     * Constructor.
     *
     * @param RateDataProviderInterface $rateDataProvider Rate data provider
     */
    public function __construct(private readonly RateDataProviderInterface $rateDataProvider)
    {
    }

    /**
     * @inheritDoc
     */
    public function getRate(string $currency): float
    {
        return $this->rateDataProvider->getRates()[$currency] ??
            throw new ExchangeRatesMissingException(sprintf(
                'Exchange rate for currency %s is missing in the data set.',
                $currency,
            ));
    }
}
