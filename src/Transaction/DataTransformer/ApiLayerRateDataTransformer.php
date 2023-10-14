<?php

declare(strict_types=1);

namespace App\Transaction\DataTransformer;

/**
 * Api layer rate data transformer.
 */
final class ApiLayerRateDataTransformer implements DataTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform(array $data): array
    {
        return $data;
    }
}
