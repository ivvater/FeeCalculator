<?php

declare(strict_types=1);

namespace App\Transaction\DataProvider;

use App\Transaction\Exception\BinLookupFailedException;

/**
 * Bin Lookup based country code provider.
 */
final class BinLookupCountryCodeProvider implements CountryCodeProviderInterface
{
    /**
     * Constructor.
     *
     * @param string $url Lookup bin list url
     */
    public function __construct(private readonly string $url)
    {
    }

    /**
     * @inheritDoc
     */
    public function getCountryCode(string $bin): string
    {
        $binResults = file_get_contents($this->url . $bin);
        if (!$binResults) {
            throw new BinLookupFailedException('Could not identify card issuance location.');
        }
        $lookupResult = json_decode($binResults);
        if (!isset($lookupResult->country->alpha2)) {
            throw new BinLookupFailedException('Could not obtain country code from bin lookup result.');
        }

        return $lookupResult->country->alpha2;
    }
}
