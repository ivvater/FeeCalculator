<?php

declare(strict_types=1);

namespace App\Transaction\Factory;

use App\Transaction\Bin\BinCheckerInterface;
use App\Transaction\Exchanger\CurrencyBasedExchangerInterface;
use App\Transaction\Fee\FeeCalculatorInterface;
use App\Transaction\Model\Transaction;

/**
 * Transaction factory.
 */
final class TransactionFactory implements TransactionFactoryInterface
{
    /**
     * Constructor.
     *
     * @param CurrencyBasedExchangerInterface $exchanger Rate exchanger
     * @param BinCheckerInterface $binChecker Bin checker
     * @param FeeCalculatorInterface $feeCalculator Fee calculator
     */
    public function __construct(
        private readonly CurrencyBasedExchangerInterface $exchanger,
        private readonly BinCheckerInterface $binChecker,
        private readonly FeeCalculatorInterface $feeCalculator,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function createFromArray(array $transactionData): Transaction
    {
        $rate = $this->exchanger->getRate($transactionData['currency']);
        return new Transaction(
            (float) $transactionData['amount'],
            $transactionData['currency'],
            $rate,
            $this->feeCalculator->calculate(
                (float) $transactionData['amount'],
                $rate,
                $this->binChecker->isCardIssuedInEu($transactionData['bin']),
            ),
        );
    }
}
