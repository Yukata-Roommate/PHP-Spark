<?php

declare(strict_types=1);

namespace Spark\Monitor\Metrics;

use Spark\Foundation\Monitor\Metrics\Metrics;

use Spark\Monitor\Metrics\System\CpuUsage;
use Spark\Monitor\Metrics\System\MemoryUsage;
use Spark\Monitor\Metrics\System\SwapMemory;
use Spark\Monitor\Metrics\System\DiskUsage;
use Spark\Monitor\Metrics\System\DiskIO;
use Spark\Monitor\Metrics\System\LoadAverage;
use Spark\Monitor\Metrics\System\Uptime;

/**
 * System Metrics
 *
 * @package Spark\Monitor\Metrics
 */
class SystemMetrics extends Metrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     *
     * @param \Spark\Monitor\Metrics\System\CpuUsage $cpuUsage
     * @param \Spark\Monitor\Metrics\System\MemoryUsage $memoryUsage
     * @param \Spark\Monitor\Metrics\System\SwapMemory $swapMemory
     * @param \Spark\Monitor\Metrics\System\DiskUsage $diskUsage
     * @param \Spark\Monitor\Metrics\System\DiskIO $diskIO
     * @param \Spark\Monitor\Metrics\System\LoadAverage $loadAverage
     * @param \Spark\Monitor\Metrics\System\Uptime $uptime
     * @param string $timestamp
     */
    public function __construct(
        CpuUsage $cpuUsage,
        MemoryUsage $memoryUsage,
        SwapMemory $swapMemory,
        DiskUsage $diskUsage,
        DiskIO $diskIO,
        LoadAverage $loadAverage,
        Uptime $uptime,
        string $timestamp
    ) {
        $this->cpuUsage    = $cpuUsage;
        $this->memoryUsage = $memoryUsage;
        $this->swapMemory  = $swapMemory;
        $this->diskUsage   = $diskUsage;
        $this->diskIO      = $diskIO;
        $this->loadAverage = $loadAverage;
        $this->uptime      = $uptime;
        $this->timestamp   = $timestamp;
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * Cpu usage
     *
     * @var \Spark\Monitor\Metrics\System\CpuUsage
     */
    public readonly CpuUsage $cpuUsage;

    /**
     * Memory usage
     *
     * @var \Spark\Monitor\Metrics\System\MemoryUsage
     */
    public readonly MemoryUsage $memoryUsage;

    /**
     * Swap memory
     *
     * @var \Spark\Monitor\Metrics\System\SwapMemory
     */
    public readonly SwapMemory $swapMemory;

    /**
     * Disk usage
     *
     * @var \Spark\Monitor\Metrics\System\DiskUsage
     */
    public readonly DiskUsage $diskUsage;

    /**
     * Disk IO
     *
     * @var \Spark\Monitor\Metrics\System\DiskIO
     */
    public readonly DiskIO $diskIO;

    /**
     * Load average
     *
     * @var \Spark\Monitor\Metrics\System\LoadAverage
     */
    public readonly LoadAverage $loadAverage;

    /**
     * Uptime
     *
     * @var \Spark\Monitor\Metrics\System\Uptime
     */
    public readonly Uptime $uptime;

    /**
     * Timestamp
     *
     * @var string
     */
    public readonly string $timestamp;

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
            "cpu"       => $this->cpuUsage->toArray(),
            "memory"    => [
                "usage" => $this->memoryUsage->toArray(),
                "swap"  => $this->swapMemory->toArray(),
            ],
            "disk"      => [
                "usage" => $this->diskUsage->toArray(),
                "io"    => $this->diskIO->toArray(),
            ],
            "load"      => $this->loadAverage->toArray(),
            "uptime"    => $this->uptime->toArray(),
            "timestamp" => $this->timestamp,
        ];
    }
}
