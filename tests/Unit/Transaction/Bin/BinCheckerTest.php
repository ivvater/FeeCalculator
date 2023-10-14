<?php

declare(strict_types=1);

namespace App\Tests\Unit\Transaction\Bin;

use App\Transaction\Bin\BinChecker;
use App\Transaction\DataProvider\CountryCodeProviderInterface;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Tests bin checker.
 */
final class BinCheckerTest extends Unit
{

    /**
     * Tests detection of card issuance in EU.
     *
     * @param string $bin Bin number
     * @param string $countryCode Country code
     * @param bool $expectedResult Expected result
     *
     * @dataProvider isCardIssuedInEuDataProvider
     */
    public function testIsCardIssuedInEu(
        string $bin,
        string $countryCode,
        bool $expectedResult,
    ): void {
        $binChecker = new BinChecker($this->createCountryCodeProviderMock($bin, $countryCode), ['DK']);
        $this->assertEquals($expectedResult, $binChecker->isCardIssuedInEu($bin));
    }

    /**
     * Returns test data for getting the winner and winning price.
     *
     * @return array Data
     */
    public static function isCardIssuedInEuDataProvider(): array
    {
        return [
            'EU country can be detected' => ['45717360', 'DK', true],
            'non-EU country can be detected' => ['123456', 'KZ', false],
        ];
    }

    /**
     * Creates mock for country code provider.
     *
     * @param string $bin Bin number
     * @param string $countryCode Country code
     * @return CountryCodeProviderInterface|MockObject Mock
     */
    private function createCountryCodeProviderMock(
        string $bin,
        string $countryCode,
    ): CountryCodeProviderInterface|MockObject {
        $countryCodeProviderMock = $this->createMock(CountryCodeProviderInterface::class);
        $countryCodeProviderMock->expects($this->once())
            ->method('getCountryCode')
            ->with($bin)
            ->willReturn($countryCode);

        return $countryCodeProviderMock;
    }
}
