<?php

declare(strict_types=1);

namespace App\Transaction\DataProvider;

use App\Transaction\DataTransformer\DataTransformerInterface;
use App\Transaction\Exception\ExchangeRatesRetrievalFailedException;

/**
 * Api Layer rate data provider.
 */
final class ApiLayerRateProvider implements RateDataProviderInterface
{
    /**
     * Constructor.
     *
     * @param DataTransformerInterface $dataTransformer Rate data transformer
     * @param string $accessKey Exchange rates api access key
     * @param string $url Api layer URL
     */
    public function __construct(
        private readonly DataTransformerInterface $dataTransformer,
        private readonly string $accessKey,
        private readonly string $url,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getRates(): array
    {
        $response = json_decode(file_get_contents($this->url . $this->accessKey), true);
        if (empty($response['rates'])) {
            throw new ExchangeRatesRetrievalFailedException(
                'Cannot get exchange rates from the source. Check your Api Layer URL and Access key.'
            );
        }

        return $this->dataTransformer->transform($response['rates']);
    }
}
