<?php

declare(strict_types=1);

namespace Spark\Contracts\Monitor;

use Spark\Contracts\Monitor\Monitor;

use Spark\Monitor\Metrics\System\CpuUsage;
use Spark\Monitor\Metrics\System\MemoryUsage;
use Spark\Monitor\Metrics\System\SwapMemory;
use Spark\Monitor\Metrics\System\DiskUsage;
use Spark\Monitor\Metrics\System\DiskIO;
use Spark\Monitor\Metrics\System\LoadAverage;
use Spark\Monitor\Metrics\System\Uptime;

use Spark\Monitor\Metrics\SystemMetrics;

/**
 * System Monitor Contract
 *
 * @package Spark\Contracts\Monitor
 */
interface SystemMonitor extends Monitor
{
    /*----------------------------------------*
     * CPU Usage
     *----------------------------------------*/

    /**
     * Get system cpu usage
     *
     * @return \Spark\Monitor\Metrics\System\CpuUsage
     */
    public function cpuUsage(): CpuUsage;

    /*----------------------------------------*
     * Memory Usage
     *----------------------------------------*/

    /**
     * Get system memory usage
     *
     * @return \Spark\Monitor\Metrics\System\MemoryUsage
     */
    public function memoryUsage(): MemoryUsage;

    /*----------------------------------------*
     * Swap Memory
     *----------------------------------------*/

    /**
     * Get system swap memory
     *
     * @return \Spark\Monitor\Metrics\System\SwapMemory
     */
    public function swapMemory(): SwapMemory;

    /*----------------------------------------*
     * Disk Usage
     *----------------------------------------*/

    /**
     * Get system disk usage
     *
     * @param string $path
     * @return \Spark\Monitor\Metrics\System\DiskUsage
     */
    public function diskUsage(string $path = "/"): DiskUsage;

    /*----------------------------------------*
     * Disk I/O
     *----------------------------------------*/

    /**
     * Get system disk I/O
     *
     * @param string $path
     * @return \Spark\Monitor\Metrics\System\DiskIO
     */
    public function diskIO(string $path = "/"): DiskIO;

    /*----------------------------------------*
     * Load Average
     *----------------------------------------*/

    /**
     * Get system load average
     *
     * @return \Spark\Monitor\Metrics\System\LoadAverage
     */
    public function loadAverage(): LoadAverage;

    /*----------------------------------------*
     * Uptime
     *----------------------------------------*/

    /**
     * Get system uptime
     *
     * @return \Spark\Monitor\Metrics\System\Uptime
     */
    public function uptime(): Uptime;

    /*----------------------------------------*
     * Metric
     *----------------------------------------*/

    /**
     * Get all metrics
     *
     * @return \Spark\Monitor\Metrics\SystemMetrics
     */
    public function metrics(): SystemMetrics;
}
