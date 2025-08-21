<?php

namespace Spark\Monitor\Metrics;

use Spark\Foundation\Monitor\Metrics\Metrics;

use Spark\Monitor\Metrics\PHP\Version;
use Spark\Monitor\Metrics\PHP\Process;
use Spark\Monitor\Metrics\PHP\CpuUsage;
use Spark\Monitor\Metrics\PHP\MemoryUsage;

/**
 * PHP Metrics
 *
 * @package Spark\Monitor\Metrics
 */
class PHPMetrics extends Metrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
     *
     * @param \Spark\Monitor\Metrics\PHP\Version $version
     * @param \Spark\Monitor\Metrics\PHP\Process $process
     * @param \Spark\Monitor\Metrics\PHP\CpuUsage $cpuUsage
     * @param \Spark\Monitor\Metrics\PHP\MemoryUsage $memoryUsage
     * @param string $timestamp
     */
    public function __construct(
        Version $version,
        Process $process,
        CpuUsage $cpuUsage,
        MemoryUsage $memoryUsage,
        string $timestamp
    ) {
        $this->version     = $version;
        $this->process     = $process;
        $this->cpuUsage    = $cpuUsage;
        $this->memoryUsage = $memoryUsage;
        $this->timestamp   = $timestamp;
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * version
     *
     * @var \Spark\Monitor\Metrics\PHP\Version
     */
    public readonly Version $version;

    /**
     * process
     *
     * @var \Spark\Monitor\Metrics\PHP\Process
     */
    public readonly Process $process;

    /**
     * cpu usage
     *
     * @var \Spark\Monitor\Metrics\PHP\CpuUsage
     */
    public readonly CpuUsage $cpuUsage;

    /**
     * memory usage
     *
     * @var \Spark\Monitor\Metrics\PHP\MemoryUsage
     */
    public readonly MemoryUsage $memoryUsage;

    /**
     * timestamp
     *
     * @var string
     */
    public readonly string $timestamp;

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
            "version"      => $this->version->toArray(),
            "process"      => $this->process->toArray(),
            "cpu_usage"    => $this->cpuUsage->toArray(),
            "memory_usage" => $this->memoryUsage->toArray(),
            "timestamp"    => $this->timestamp,
        ];
    }
}
