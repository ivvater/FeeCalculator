<?php

declare(strict_types=1);

namespace App\Transaction\Exception;

use RuntimeException;

/**
 * Exception: exchange rates retrieved successfully, but the rate for given currency does not exist.
 */
final class ExchangeRatesMissingException extends RuntimeException
{
}
