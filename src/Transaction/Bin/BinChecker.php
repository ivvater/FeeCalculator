<?php

declare(strict_types=1);

namespace App\Transaction\Bin;

use App\Transaction\DataProvider\CountryCodeProviderInterface;

/**
 * Bin checker.
 */
final class BinChecker implements BinCheckerInterface
{
    /**
     * Constructor.
     *
     * @param CountryCodeProviderInterface $countryCodeProvider Country code provider
     * @param string[] $euCountryCodes The list of country codes considered as EU countries
     */
    public function __construct(
        private readonly CountryCodeProviderInterface $countryCodeProvider,
        private readonly array $euCountryCodes,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function isCardIssuedInEu(string $bin): bool
    {
        return $this->issuedInEu($this->countryCodeProvider->getCountryCode($bin));
    }

    /**
     * Checks if given country code considered as EU or not.
     *
     * @param string $countryCode Country code
     * @return bool Whether the country code considered as EU or not
     */
    private function issuedInEu(string $countryCode): bool
    {
        return in_array($countryCode, $this->euCountryCodes);
    }
}
