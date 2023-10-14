<?php

declare(strict_types=1);

namespace App\Generator;

use Iterator;

/**
 * Interface: from file json line generator.
 */
interface FromFileJsonLineGeneratorInterface extends Iterator
{
    /**
     * Reads the file.
     *
     * @param string $filename Filename
     */
    public function readFile(string $filename): void;
}
