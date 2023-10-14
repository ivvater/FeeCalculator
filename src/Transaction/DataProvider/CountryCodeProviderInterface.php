<?php

declare(strict_types=1);

namespace App\Transaction\DataProvider;

/**
 * Interface: country code provider.
 */
interface CountryCodeProviderInterface
{
    /**
     * Retrieves country code where card was issued by bin number.
     *
     * @param string $bin Bin number of the card
     * @return string Country code
     */
    public function getCountryCode(string $bin): string;
}
