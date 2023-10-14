<?php

declare(strict_types=1);

namespace App\Transaction\Model;

use LogicException;

/**
 * Transaction model
 */
final class Transaction
{
    /**
     * Constructor.
     *
     * @param float $amount Transaction amount
     * @param string $currency Transaction currency
     * @param float $rate The rate that is actual for the transaction
     * @param float $fee Calculated fee
     */
    public function __construct(
        private readonly float $amount,
        private readonly string $currency,
        private readonly float $rate,
        private readonly float $fee,
    ) {
        // TODO it's better to pass $rate as the value object and validate for zero there
        if (!$rate) {
            throw new LogicException('Rate must be set as a positive number for transaction.');
        }
    }

    /**
     * @return float Transaction amount
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string Transaction currency
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return float Exchange rate to convert transaction amount to EUR
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @return float Transaction fee
     */
    public function getFee(): float
    {
        return $this->fee;
    }
}
