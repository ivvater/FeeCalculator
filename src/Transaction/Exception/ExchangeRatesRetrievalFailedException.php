<?php

declare(strict_types=1);

namespace App\Transaction\Exception;

use RuntimeException;

/**
 * Exception: exchange rates retrieval failed.
 */
final class ExchangeRatesRetrievalFailedException extends RuntimeException
{
}
