<?php

declare(strict_types=1);

namespace App\Transaction\Factory;

use App\Transaction\Model\Transaction;

/**
 * Interface: transaction factory.
 */
interface TransactionFactoryInterface
{
    /**
     * Creates transaction from array.
     *
     * @param array $transactionData Transaction data
     * @return Transaction Transaction
     */
    public function createFromArray(array $transactionData): Transaction;
}
