<?php

namespace Spark\Monitor\Metrics\System;

use Spark\Foundation\Monitor\Metrics\EmptiableMetrics;

/**
 * System Swap Memory
 *
 * @package Spark\Monitor\Metrics\System
 */
class SwapMemory extends EmptiableMetrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
     *
     * @param float $total
     * @param float $used
     * @param float $free
     * @param float $percentage
     */
    public function __construct(
        float $total,
        float $used,
        float $free,
        float $percentage,
    ) {
        $this->total      = $total;
        $this->used       = $used;
        $this->free       = $free;
        $this->percentage = $percentage;
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * total swap memory
     *
     * @var float
     */
    public readonly float $total;

    /**
     * used swap memory
     *
     * @var float
     */
    public readonly float $used;

    /**
     * free swap memory
     *
     * @var float
     */
    public readonly float $free;

    /**
     * percentage of used swap memory
     *
     * @var float
     */
    public readonly float $percentage;

    /*----------------------------------------*
     * Emptiable
     *----------------------------------------*/

    /**
     * make empty
     *
     * @return static
     */
    public static function empty(): static
    {
        return new self(0.0, 0.0, 0.0, 0.0);
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
            "total"      => $this->total,
            "used"       => $this->used,
            "free"       => $this->free,
            "percentage" => $this->percentage,
            "formatted"  => [
                "total"      => $this->formatBytes($this->total),
                "used"       => $this->formatBytes($this->used),
                "free"       => $this->formatBytes($this->free),
                "percentage" => $this->formatPercentage($this->percentage / 100),
            ],
        ];
    }
}
