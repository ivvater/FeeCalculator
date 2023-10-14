<?php

declare(strict_types=1);

namespace App\Transaction\DataTransformer;

/**
 * Interface: data transformer.
 */
interface DataTransformerInterface
{
    /**
     * Transforms the data to an appropriate format.
     *
     * @param array $data Data to be transformed
     * @return array Transformed data
     */
    public function transform(array $data): array;
}
