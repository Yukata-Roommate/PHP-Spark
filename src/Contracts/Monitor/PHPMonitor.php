<?php

namespace Spark\Contracts\Monitor;

use Spark\Contracts\Monitor\Monitor;

use Spark\Monitor\Metrics\PHP\Version;
use Spark\Monitor\Metrics\PHP\Process;
use Spark\Monitor\Metrics\PHP\CpuUsage;
use Spark\Monitor\Metrics\PHP\MemoryUsage;

use Spark\Monitor\Metrics\PHPMetrics;

/**
 * PHP Monitor Contract
 *
 * @package Spark\Contracts\Monitor
 */
interface PHPMonitor extends Monitor
{
    /*----------------------------------------*
     * Version
     *----------------------------------------*/

    /**
     * get php version
     *
     * @return \Spark\Monitor\Metrics\PHP\Version
     */
    public function version(): Version;

    /*----------------------------------------*
     * Process
     *----------------------------------------*/

    /**
     * get php process
     *
     * @return \Spark\Monitor\Metrics\PHP\Process
     */
    public function process(): Process;

    /*----------------------------------------*
     * CPU Usage
     *----------------------------------------*/

    /**
     * get php cpu usage
     *
     * @return \Spark\Monitor\Metrics\PHP\CpuUsage
     */
    public function cpuUsage(): CpuUsage;

    /*----------------------------------------*
     * Memory Usage
     *----------------------------------------*/

    /**
     * get php memory usage
     *
     * @return \Spark\Monitor\Metrics\PHP\MemoryUsage
     */
    public function memoryUsage(): MemoryUsage;

    /*----------------------------------------*
     * Metric
     *----------------------------------------*/

    /**
     * get all metrics
     *
     * @return \Spark\Monitor\Metrics\PHPMetrics
     */
    public function metrics(): PHPMetrics;
}
