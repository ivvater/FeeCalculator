<?php

declare(strict_types=1);

namespace App\Transaction\Fee;

/**
 * Interface: fee calculator.
 */
interface FeeCalculatorInterface
{
    /**
     * Checks whether the card was issued in EU or not.
     *
     * @param float $transactionAmount Amount of the transaction
     * @param float $rate Exchange rate
     * @param bool $isCardIssuedInEu Whether the transaction card was issued in EU
     * @return float Calculated fee
     */
    public function calculate(float $transactionAmount, float $rate, bool $isCardIssuedInEu): float;
}
