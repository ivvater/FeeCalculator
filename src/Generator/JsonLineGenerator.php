<?php

declare(strict_types=1);

namespace App\Generator;

use RuntimeException;

/**
 * Very simple implementation of generator for json lines.
 */
final class JsonLineGenerator implements FromFileJsonLineGeneratorInterface
{
    private readonly mixed $fileHandle;
    private ?string $currentLine;
    private int $key = 0;

    /**
     * Reads the file.
     *
     * @param string $filename Filename
     */
    public function readFile(string $filename): void
    {
        $this->fileHandle = fopen($filename, 'r');
        if (!$this->fileHandle) {
            throw new RuntimeException("Could not open the file.");
        }
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        fseek($this->fileHandle, 0);
        $this->currentLine = $this->readLine();
        $this->key = 0;
    }

    /**
     * @inheritDoc
     */
    public function current(): mixed
    {
        return json_decode($this->currentLine, true);
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        $this->currentLine = $this->readLine();
        $this->key++;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->currentLine !== null;
    }

    /**
     * Destructs file handle.
     */
    public function __destruct() {
        fclose($this->fileHandle);
    }

    /**
     * @return string|null The content of the current line or null, if no line.
     */
    private function readLine(): ?string
    {
        if (!$line = fgets($this->fileHandle)) {
            return null;
        }

        return $line;
    }
}
