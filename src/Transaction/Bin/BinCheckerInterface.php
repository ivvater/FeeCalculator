<?php

declare(strict_types=1);

namespace App\Transaction\Bin;

/**
 * Interface: bin checker.
 */
interface BinCheckerInterface
{
    /**
     * Checks whether the card was issued in EU or not.
     *
     * @param string $bin Bin number
     * @return bool Whether the card was issued in EU or not
     */
    public function isCardIssuedInEu(string $bin): bool;
}
