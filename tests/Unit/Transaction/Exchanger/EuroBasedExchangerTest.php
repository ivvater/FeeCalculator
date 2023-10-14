<?php

declare(strict_types=1);

namespace App\Tests\Unit\Transaction\Exchanger;

use App\Transaction\DataProvider\RateDataProviderInterface;
use App\Transaction\Exception\ExchangeRatesMissingException;
use App\Transaction\Exchanger\EuroBasedExchanger;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Tests exchanger.
 */
final class EuroBasedExchangerTest extends Unit
{

    /**
     * Tests getting rates from exchanger.
     *
     * @param string $currency Currency
     * @param float $expectedResult Expected result
     *
     * @dataProvider getRatesDataProvider
     */
    public function testGetRates(
        string $currency,
        float $expectedResult,
    ): void {
        $exchanger = new EuroBasedExchanger($this->createCountryCodeProviderMock());
        $this->assertEquals($expectedResult, $exchanger->getRate($currency));
    }

    /**
     * Tests exception thrown.
     *
     * @param string $currency Currency
     * @param string $expectedException Expected exception
     *
     * @dataProvider exceptionThrownDataProvider
     */
    public function testExceptionThrown(
        string $currency,
        string $expectedException,
    ): void {
        $exchanger = new EuroBasedExchanger($this->createCountryCodeProviderMock());
        $this->expectException($expectedException);
        $exchanger->getRate($currency);
    }

    /**
     * Returns test data for getting rates.
     *
     * @return array Data
     */
    public static function getRatesDataProvider(): array
    {
        return [
            'existent currency rates can be obtained' => ['AED', 4.147043],
            'exchange rate from EUR to EUR can be obtained' => ['EUR', 1],
        ];
    }

    /**
     * Returns test data for testing exceptions.
     *
     * @return array<string, string[]> Data
     */
    public static function exceptionThrownDataProvider(): array
    {
        return [
            'exception thrown when no rate for given currency' => [
                'NOT_A_CURRENCY',
                ExchangeRatesMissingException::class,
            ],
        ];
    }

    /**
     * Creates mock for CountryCodeProvider.
     *
     * @return RateDataProviderInterface|MockObject Mock
     */
    private function createCountryCodeProviderMock(): RateDataProviderInterface|MockObject
    {
        $countryCodeProviderMock = $this->createMock(RateDataProviderInterface::class);
        $countryCodeProviderMock->expects($this->once())
            ->method('getRates')
            ->willReturn($this->getMockedRates());

        return $countryCodeProviderMock;
    }

    /**
     * Gets mocked rates.
     *
     * @return array<string, float> Rates
     */
    private function getMockedRates(): array
    {
        return [
            'AED' => 4.147043,
            'USD' => 1.129031,
            'EUR' => 1,
        ];
    }
}
