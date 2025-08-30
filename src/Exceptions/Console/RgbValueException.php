<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\OutputException;

/**
 * RGB Value Exception
 *
 * @package Spark\Exceptions\Console
 */
class RgbValueException extends OutputException
{
    /**
     * RGB color name
     *
     * @var string
     */
    protected string $colorName;

    /**
     * Invalid value
     *
     * @var int
     */
    protected int $value;

    /**
     * Min valid value
     *
     * @var int
     */
    protected int $min;

    /**
     * Max valid value
     *
     * @var int
     */
    protected int $max;

    /**
     * Constructor
     *
     * @param string $colorName
     * @param int $value
     * @param int $min
     * @param int $max
     */
    public function __construct(string $colorName, int $value, int $min, int $max)
    {
        $this->colorName = $colorName;
        $this->value     = $value;
        $this->min       = $min;
        $this->max       = $max;

        parent::__construct("Invalid RGB {$colorName} value: {$value}. Valid range: {$min}-{$max}");
    }

    /**
     * Get color name
     *
     * @return string
     */
    public function colorName(): string
    {
        return $this->colorName;
    }

    /**
     * Get invalid value
     *
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * Get min valid value
     *
     * @return int
     */
    public function min(): int
    {
        return $this->min;
    }

    /**
     * Get max valid value
     *
     * @return int
     */
    public function max(): int
    {
        return $this->max;
    }
}
