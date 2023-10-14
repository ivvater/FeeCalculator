<?php

declare(strict_types=1);

namespace App\Tests\Unit\Transaction\Fee;

use App\Transaction\Fee\FeeCalculator;
use Codeception\Test\Unit;

/**
 * Tests fee calculator.
 */
final class FeeCalculatorTest extends Unit
{
    /**
     * Tests fee calculator.
     *
     * @param float $transactionAmount Transaction amount
     * @param float $exchangeRate Exchange rate
     * @param bool $isCardIssuedInEu Whether the card issued in EU or not
     * @param float $expectedResult Expected result
     *
     * @dataProvider calculateDataProvider
     */
    public function testCalculate(
        float $transactionAmount,
        float $exchangeRate,
        bool $isCardIssuedInEu,
        float $expectedResult,
    ): void {
        $feeCalculator = new FeeCalculator();

        $this->assertEquals(
            $expectedResult,
            $feeCalculator->calculate($transactionAmount, $exchangeRate, $isCardIssuedInEu),
        );
    }

    /**
     * Returns test data for testing transactions fee.
     *
     * @return array<string, array<array<int, mixed>>> Data
     */
    public static function calculateDataProvider(): array
    {
        return [
            'case from task 1' => [100.00, 1, true, 1],
            'case from task 2' => [50.00, 1.129031, true, 0.45],
            'case from task 3' => [10000.00, 130.869977, false, 1.53],
            'case from task 4' => [130.00, 1.129031, false, 2.31],
            'case from task 5' => [2000.00, 0.835342, false, 47.89],
        ];
    }
}
