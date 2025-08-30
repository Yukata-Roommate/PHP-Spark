<?php

declare(strict_types=1);

namespace Spark\Monitor\Metrics\System;

use Spark\Foundation\Monitor\Metrics\EmptiableMetrics;

/**
 * System Disk Usage
 *
 * @package Spark\Monitor\Metrics\System
 */
class DiskUsage extends EmptiableMetrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     *
     * @param float $total
     * @param float $used
     * @param float $free
     * @param float $percentage
     */
    public function __construct(float $total, float $used, float $free, float $percentage)
    {
        $this->total      = $total;
        $this->used       = $used;
        $this->free       = $free;
        $this->percentage = $percentage;
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * Total disk space
     *
     * @var float
     */
    public readonly float $total;

    /**
     * Used disk space
     *
     * @var float
     */
    public readonly float $used;

    /**
     * Free disk space
     *
     * @var float
     */
    public readonly float $free;

    /**
     * Percentage of used disk
     *
     * @var float
     */
    public readonly float $percentage;

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
        return new self(0.0, 0.0, 0.0, 0.0);
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
            "total"      => $this->total,
            "used"       => $this->used,
            "free"       => $this->free,
            "percentage" => $this->percentage,
            "formatted"  => [
                "total"      => $this->formatBytes($this->total),
                "used"       => $this->formatBytes($this->used),
                "free"       => $this->formatBytes($this->free),
                "percentage" => $this->formatPercentage($this->percentage),
            ],
        ];
    }
}
