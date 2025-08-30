<?php

declare(strict_types=1);

namespace Spark\Supports\Superglobals;

use Spark\Foundation\Container\Reference;

/**
 * Env Reference
 *
 * @package Spark\Supports\Superglobals
 */
class Env extends Reference
{
    /*----------------------------------------*
     * Reference
     *----------------------------------------*/

    /**
     * Get reference
     *
     * @return array
     */
    protected function &reference(): array
    {
        return $_ENV;
    }

    /*----------------------------------------*
     * Accessor
     *----------------------------------------*/

    /**
     * Get value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    #[\Override]
    public function get(string $key, mixed $default = null): mixed
    {
        return parent::get($key, $default) ?? getenv($key) ?: $default;
    }

    /*----------------------------------------*
     * Check
     *----------------------------------------*/

    /**
     * Whether has key
     *
     * @param string $key
     * @return bool
     */
    #[\Override]
    public function has(string $key): bool
    {
        return parent::has($key) || getenv($key) !== false;
    }

    /*----------------------------------------*
     * Use System
     *----------------------------------------*/

    /**
     * Whether use system env
     *
     * @var bool
     */
    protected bool $useSystemEnv = false;

    /**
     * Set use system env
     *
     * @param bool $useSystemEnv
     * @return void
     */
    public function setUseSystemEnv(bool $useSystemEnv): void
    {
        $this->useSystemEnv = $useSystemEnv;
    }

    /**
     * Use system env
     *
     * @return void
     */
    public function useSystemEnv(): void
    {
        $this->setUseSystemEnv(true);
    }

    /**
     * Unuse system env
     *
     * @return void
     */
    public function unuseSystemEnv(): void
    {
        $this->setUseSystemEnv(false);
    }

    /*----------------------------------------*
     * Set
     *----------------------------------------*/

    /**
     * Set value
     *
     * @param string $key
     * @param string $value
     * @param bool $useSystemEnv
     * @return void
     */
    public function set(string $key, string $value, bool $useSystemEnv = false): void
    {
        $reference = &$this->reference();

        $reference[$key] = $value;

        if (!$this->useSystemEnv && !$useSystemEnv) return;

        putenv("{$key}={$value}");
    }

    /*----------------------------------------*
     * Remove
     *----------------------------------------*/

    /**
     * Remove value
     *
     * @param string $key
     * @param bool $useSystemEnv
     * @return void
     */
    public function remove(string $key, bool $useSystemEnv = false): void
    {
        $reference = &$this->reference();

        unset($reference[$key]);

        if (!$this->useSystemEnv && !$useSystemEnv) return;

        putenv($key);
    }

    /*----------------------------------------*
     * Load
     *----------------------------------------*/

    /**
     * Load values from file
     *
     * @param string $file
     * @param bool $useSystemEnv
     * @return void
     */
    public function load(string $file, bool $useSystemEnv = false): void
    {
        if (!file_exists($file)) throw new \RuntimeException("Environment file not found: $file");

        if (!is_readable($file)) throw new \RuntimeException("Environment file is not readable: $file");

        foreach ($this->readFileLines($file) as $data) {
            $this->set($data->key, $data->value, $useSystemEnv);
        }
    }

    /**
     * Read file lines
     *
     * @param string $file
     * @return \Generator
     */
    protected function readFileLines(string $file): \Generator
    {
        $handle = fopen($file, "r");

        if (!$handle) throw new \RuntimeException("Failed to open environment file: $file");

        try {
            $row = 0;

            while (($line = fgets($handle)) !== false) {
                $row++;

                $line = rtrim($line, "\r\n");

                if (empty($line) || str_starts_with($line, "#")) continue;

                yield $this->parsedLine($file, $line, $row);
            }
        } finally {
            fclose($handle);
        }
    }

    /**
     * Get parsed line
     *
     * @param string $file
     * @param string $line
     * @param int $row
     * @return \stdClass
     */
    protected function parsedLine(string $file, string $line, int $row): \stdClass
    {
        $equalPos = strpos($line, "=");

        if ($equalPos === false) throw new \RuntimeException("Missing \"=\" separator at line $row in $file: $line");

        $key   = trim(substr($line, 0, $equalPos));
        $value = trim(substr($line, $equalPos + 1));

        if (empty($key)) throw new \RuntimeException("Empty key at line $row in $file: $line");

        if (!preg_match("/^[A-Za-z_][A-Za-z0-9_]*$/", $key)) throw new \RuntimeException("Invalid key format \"$key\" at line $row in $file: $line");

        $data = new \stdClass();

        $data->key   = $key;
        $data->value = $this->removeQuotes($value);

        return $data;
    }

    /**
     * Remove quotes from value
     *
     * @param string $value
     * @return string
     */
    protected function removeQuotes(string $value): string
    {
        if (empty($value) || strlen($value) < 2) return $value;

        $enclosedSingleQuote = str_starts_with($value, "'") && str_ends_with($value, "'");
        $enclosedDoubleQuote = str_starts_with($value, "\"") && str_ends_with($value, "\"");

        return $enclosedSingleQuote || $enclosedDoubleQuote ? substr($value, 1, -1) : $value;
    }
}
