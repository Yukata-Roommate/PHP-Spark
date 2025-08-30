<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\OutputException;

/**
 * Color Code Exception
 *
 * @package Spark\Exceptions\Console
 */
class ColorCodeException extends OutputException
{
    /**
     * Invalid color code
     *
     * @var int
     */
    protected int $colorCode;

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
     * @param int $colorCode
     * @param int $min
     * @param int $max
     */
    public function __construct(int $colorCode, int $min, int $max)
    {
        $this->colorCode = $colorCode;
        $this->min       = $min;
        $this->max       = $max;

        parent::__construct("Invalid color code {$colorCode}. Valid range: {$min}-{$max}");
    }

    /**
     * Get color code
     *
     * @return int
     */
    public function colorCode(): int
    {
        return $this->colorCode;
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
