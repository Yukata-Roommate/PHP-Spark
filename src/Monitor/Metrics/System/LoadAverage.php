<?php

declare(strict_types=1);

namespace Spark\Monitor\Metrics\System;

use Spark\Foundation\Monitor\Metrics\EmptiableMetrics;

/**
 * System Load Average
 *
 * @package Spark\Monitor\Metrics\System
 */
class LoadAverage extends EmptiableMetrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     *
     * @param float $oneMinute
     * @param float $fiveMinutes
     * @param float $fifteenMinutes
     */
    public function __construct(float $oneMinute, float $fiveMinutes, float $fifteenMinutes)
    {
        $this->oneMinute      = $oneMinute;
        $this->fiveMinutes    = $fiveMinutes;
        $this->fifteenMinutes = $fifteenMinutes;
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * One minute load average
     *
     * @var float
     */
    public readonly float $oneMinute;

    /**
     * Five minutes load average
     *
     * @var float
     */
    public readonly float $fiveMinutes;

    /**
     * Fifteen minutes load average
     *
     * @var float
     */
    public readonly float $fifteenMinutes;

    /*----------------------------------------*
     * Emptiable
     *----------------------------------------*/

    /**
     * Make empty
     *
     * @return static
     */
    public static function empty(): static
    {
        return new self(0.0, 0.0, 0.0);
    }

    /*----------------------------------------*
     * To Array
     *----------------------------------------*/

    /**
     * To array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            "1min"  => $this->oneMinute,
            "5min"  => $this->fiveMinutes,
            "15min" => $this->fifteenMinutes,
        ];
    }
}
