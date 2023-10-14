<?php

declare(strict_types=1);

namespace App\Transaction\Fee;

use LogicException;

/**
 * Interface: fee calculator.
 */
final class FeeCalculator implements FeeCalculatorInterface
{
    /**
     * Coefficient used for fee calculation for EU issued cards
     */
    private const EU_FEE_COEFFICIENT = 0.01;

    /**
     * Coefficient used for fee calculation for non-EU issued cards
     */
    private const NON_EU_FEE_COEFFICIENT = 0.02;

    /**
     * @inheritDoc
     */
    public function calculate(float $transactionAmount, float $rate, bool $isCardIssuedInEu): float
    {
        // TODO it's better to pass $rate as the value object and validate for zero there
        if (!$rate) {
            throw new LogicException('Rate of the transaction cannot be zero.');
        }
        $fee = ($transactionAmount / $rate) * $this->getFeeCoefficient($isCardIssuedInEu);

        return ceil($fee * 100) / 100;
    }

    /**
     * Gets actual for transaction fee coefficient.
     *
     * @param bool $isCardIssuedInEu Whether the transaction card was issued in EU
     * @return float Transaction fee coefficient
     */
    private function getFeeCoefficient(bool $isCardIssuedInEu): float
    {
        return $isCardIssuedInEu ? self::EU_FEE_COEFFICIENT : self::NON_EU_FEE_COEFFICIENT;
    }
}
