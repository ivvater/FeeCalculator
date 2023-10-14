<?php

declare(strict_types=1);

namespace App\Tests\Unit\Transaction\Factory;

use App\Transaction\Bin\BinCheckerInterface;
use App\Transaction\Exchanger\CurrencyBasedExchangerInterface;
use App\Transaction\Factory\TransactionFactory;
use App\Transaction\Fee\FeeCalculatorInterface;
use App\Transaction\Model\Transaction;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Tests creating of the transactions by transaction factory.
 */
final class TransactionFactoryTest extends Unit
{
    /**
     * Tests transaction factory.
     *
     * @param array $transactionData Transaction data
     * @param float $exchangeRate Exchange rate
     * @param bool $isCardIssuedInEu Whether the card issued in EU or not
     * @param float $fee Calculated fee
     *
     * @dataProvider transactionFactoryDataProvider
     */
    public function testCreateFromArray(
        array $transactionData,
        float $exchangeRate,
        bool $isCardIssuedInEu,
        float $fee,
    ): void {
        $transactionFactory = new TransactionFactory(
            $this->createExchangerMock($transactionData['currency'], $exchangeRate),
            $this->createBinCheckerMock($transactionData['bin'], $isCardIssuedInEu),
            $this->createFeeCalculatorMock($transactionData['amount'], $exchangeRate, $isCardIssuedInEu, $fee),
        );
        $transaction = $transactionFactory->createFromArray($transactionData);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals($fee, $transaction->getFee());
        $this->assertEquals($exchangeRate, $transaction->getRate());
    }

    /**
     * Returns test data for testing transactions fee.
     *
     * @return array<string, array<array<int, mixed>>> Data
     */
    public static function transactionFactoryDataProvider(): array
    {
        return [
            'correct transaction created' => [
                ['bin' => '45717360', 'amount' => 100.00, 'currency' => 'EUR'],
                1,
                true,
                1,
            ],
        ];
    }

    /**
     * Creates Exchanger mock.
     *
     * @param string $currency Currency
     * @param float $rate Rate
     * @return CurrencyBasedExchangerInterface|MockObject Mock
     */
    private function createExchangerMock(string $currency, float $rate): CurrencyBasedExchangerInterface|MockObject
    {
        $exchangerMock = $this->createMock(CurrencyBasedExchangerInterface::class);
        $exchangerMock->expects($this->once())
            ->method('getRate')
            ->with($currency)
            ->willReturn($rate);

        return $exchangerMock;
    }

    /**
     * Creates BinChecker mock.
     *
     * @param string $bin Bin number
     * @param bool $isCardIssuedInEu Whether the card was issued in EU or not
     * @return BinCheckerInterface|MockObject Mock
     */
    private function createBinCheckerMock(string $bin, bool $isCardIssuedInEu): BinCheckerInterface|MockObject
    {
        $binCheckerMock = $this->createMock(BinCheckerInterface::class);
        $binCheckerMock->expects($this->once())
            ->method('isCardIssuedInEu')
            ->with($bin)
            ->willReturn($isCardIssuedInEu);

        return $binCheckerMock;
    }

    /**
     * Creates BinChecker mock.
     *
     * @param float $amount Transaction amount
     * @param float $rate Transaction rate
     * @param bool $isCardIssuedInEu Whether the card was issued in EU or not
     * @param float $fee Calculated fee
     * @return FeeCalculatorInterface|MockObject Mock
     */
    private function createFeeCalculatorMock(
        float $amount,
        float $rate,
        bool $isCardIssuedInEu,
        float $fee,
    ): FeeCalculatorInterface|MockObject {
        $binCheckerMock = $this->createMock(FeeCalculatorInterface::class);
        $binCheckerMock->expects($this->once())
            ->method('calculate')
            ->with($amount, $rate, $isCardIssuedInEu)
            ->willReturn($fee);

        return $binCheckerMock;
    }
}
