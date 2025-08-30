<?php

declare(strict_types=1);

namespace Spark\DB;

use Spark\Contracts\DB\MySQLDumper as MySQLDumperContract;
use Spark\Foundation\DB\Dumper;

use Spark\Proxies\Text;

/**
 * MySQL Dumper
 *
 * @package Spark\DB
 */
class MySQLDumper extends Dumper implements MySQLDumperContract
{
    /*----------------------------------------*
     * Dump Database
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function driver(): string
    {
        return "mysql";
    }

    /**
     * {@inheritDoc}
     */
    protected function setCommand(): void
    {
        $this->addDriverName();
        $this->addDatabase();
        $this->addOptions();
        $this->addDumpFile();
    }

    /**
     * Add database
     *
     * @return void
     */
    protected function addDatabase(): void
    {
        match (true) {
            $this->allDatabases            => $this->addAllDatabases(),
            count($this->database()) === 1 => $this->addDatabaseName(),
            count($this->database()) > 1   => $this->addDatabaseNames(),
        };
    }

    /**
     * Add option to command
     *
     * @return void
     */
    protected function addOptions(): void
    {
        foreach ($this->options() as $option) {
            $this->addCommand($option);
        }
    }

    /*----------------------------------------*
     * Database
     *----------------------------------------*/

    /**
     * All databases
     *
     * @var bool
     */
    protected bool $allDatabases = false;

    /**
     * Database names
     *
     * @var array<string>
     */
    protected array $databases = [];

    /**
     * Table names
     *
     * @var array<string>
     */
    protected array $tables = [];

    /**
     * {@inheritDoc}
     */
    public function allDatabases(): bool
    {
        return $this->allDatabases;
    }

    /**
     * {@inheritDoc}
     */
    public function setAllDatabases(bool $allDatabases = true): static
    {
        $this->allDatabases = $allDatabases;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function databases(): array
    {
        return $this->databases;
    }

    /**
     * {@inheritDoc}
     */
    public function setDatabases(string|array $database): static
    {
        $this->databases = is_array($database) ? $database : [$database];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function tables(): array
    {
        return $this->tables;
    }

    /**
     * {@inheritDoc}
     */
    public function setTables(array $tables): static
    {
        $this->tables = $tables;

        return $this;
    }

    /**
     * Add all databases
     *
     * @return void
     */
    protected function addAllDatabases(): void
    {
        $this->addCommand("--all-databases");
    }

    /**
     * Add database name and table names
     *
     * @return void
     */
    protected function addDatabaseName(): void
    {
        $this->addCommand($this->databases()[0]);

        if (empty($this->tables())) return;

        foreach ($this->tables() as $table) {
            $this->addCommand($table);
        }
    }

    /**
     * Add database names
     *
     * @return void
     */
    protected function addDatabaseNames(): void
    {
        $this->addCommand("--databases");

        foreach ($this->databases() as $database) {
            $this->addCommand($database);
        }
    }

    /*----------------------------------------*
     * Option
     *----------------------------------------*/

    /**
     * Options
     *
     * @var array<string>
     */
    protected array $options = [];

    /**
     * {@inheritDoc}
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * {@inheritDoc}
     */
    public function optionString(): string
    {
        return implode(" ", $this->options());
    }

    /**
     * {@inheritDoc}
     */
    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addOption(string $name, string|array|null $value = null): static
    {
        $name = $this->formatOptionName($name);

        $value = $this->formatOptionValue($value);

        $this->options[] = $this->formatOption($name, $value);

        return $this;
    }

    /**
     * Format option name
     *
     * @param string $name
     * @return string
     */
    protected function formatOptionName(string $name): string
    {
        return $name;
    }

    /**
     * Format option value
     *
     * @param string|array<string>|null $value
     * @return string|null
     */
    protected function formatOptionValue(string|array|null $value): string|null
    {
        return match (true) {
            is_null($value)  => null,
            empty($value)    => null,
            is_array($value) => implode(",", $value),

            default => $value,
        };
    }

    /**
     * Format option
     *
     * @param string $name
     * @param string|null $value
     * @return string
     */
    protected function formatOption(string $name, string|null $value): string
    {
        return is_null($value) ? $name : "{$name}={$value}";
    }

    /**
     * Call add option
     *
     * @param string $name
     * @param array<string> $arguments
     * @return static
     */
    public function __call(string $name, array $arguments): static
    {
        $name = Text::toKebab($name);

        $value = $arguments[0] ?? null;

        return $this->addOption("--{$name}", $value);
    }
}
