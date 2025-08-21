<?php

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
     * constructor
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
     * read speed
     *
     * @var float
     */
    public readonly float $readSpeed;

    /**
     * write speed
     *
     * @var float
     */
    public readonly float $writeSpeed;

    /**
     * read operations per second
     *
     * @var int
     */
    public readonly int $readOps;

    /**
     * write operations per second
     *
     * @var int
     */
    public readonly int $writeOps;

    /**
     * average I/O wait time
     *
     * @var float
     */
    public readonly float $avgWaitTime;

    /**
     * disk utilization percentage
     *
     * @var float
     */
    public readonly float $utilization;

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
        return new self(0.0, 0.0, 0, 0, 0.0, 0.0);
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
