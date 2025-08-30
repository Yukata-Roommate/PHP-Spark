<?php

declare(strict_types=1);

namespace Spark\Monitor\Metrics\System;

use Spark\Foundation\Monitor\Metrics\EmptiableMetrics;

/**
 * System Disk I/O
 *
 * @package Spark\Monitor\Metrics\System
 */
class DiskIO extends EmptiableMetrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     *
     * @param float $readSpeed
     * @param float $writeSpeed
     * @param int $readOps
     * @param int $writeOps
     * @param float $avgWaitTime
     * @param float $utilization
     */
    public function __construct(
        float $readSpeed,
        float $writeSpeed,
        int $readOps,
        int $writeOps,
        float $avgWaitTime,
        float $utilization
    ) {
        $this->readSpeed   = $readSpeed;
        $this->writeSpeed  = $writeSpeed;
        $this->readOps     = $readOps;
        $this->writeOps    = $writeOps;
        $this->avgWaitTime = $avgWaitTime;
        $this->utilization = $utilization;
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * Read speed
     *
     * @var float
     */
    public readonly float $readSpeed;

    /**
     * Write speed
     *
     * @var float
     */
    public readonly float $writeSpeed;

    /**
     * Read operations per second
     *
     * @var int
     */
    public readonly int $readOps;

    /**
     * Write operations per second
     *
     * @var int
     */
    public readonly int $writeOps;

    /**
     * Average I/O wait time
     *
     * @var float
     */
    public readonly float $avgWaitTime;

    /**
     * Disk utilization percentage
     *
     * @var float
     */
    public readonly float $utilization;

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
        return new self(0.0, 0.0, 0, 0, 0.0, 0.0);
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
            "read_speed"    => $this->readSpeed,
            "write_speed"   => $this->writeSpeed,
            "read_ops"      => $this->readOps,
            "write_ops"     => $this->writeOps,
            "avg_wait_time" => $this->avgWaitTime,
            "utilization"   => $this->utilization,
            "formatted"     => [
                "read_speed"    => sprintf("%.2f MB/s", $this->readSpeed),
                "write_speed"   => sprintf("%.2f MB/s", $this->writeSpeed),
                "read_ops"      => sprintf("%d IOPS", $this->readOps),
                "write_ops"     => sprintf("%d IOPS", $this->writeOps),
                "avg_wait_time" => sprintf("%.2f ms", $this->avgWaitTime),
                "utilization"   => $this->formatPercentage($this->utilization / 100),
            ],
        ];
    }
}
