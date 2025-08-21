<?php

namespace Spark\Monitor\Metrics\System;

use Spark\Foundation\Monitor\Metrics\EmptiableMetrics;

/**
 * System Uptime
 *
 * @package Spark\Monitor\Metrics\System
 */
class Uptime extends EmptiableMetrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
     *
     * @param int $seconds
     */
    public function __construct(int $seconds)
    {
        $this->seconds = $seconds;
    }

    /*----------------------------------------*
     * Emptiable
     *----------------------------------------*/

    /**
     * uptime in seconds
     *
     * @var int
     */
    public readonly int $seconds;

    /**
     * make empty
     *
     * @return static
     */
    public static function empty(): static
    {
        return new self(0);
    }

    /*----------------------------------------*
     * To Array
     *----------------------------------------*/

    /**
     * to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            "seconds"   => $this->seconds,
            "formatted" => $this->formatSeconds($this->seconds),
        ];
    }
}
