<?php

namespace Spark\Monitor\Metrics;

use Spark\Foundation\Monitor\Metrics\Metrics;

/**
 * Process Metrics
 *
 * @package Spark\Monitor\Metrics
 */
class ProcessMetrics extends Metrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
     *
     * @param string $name
     * @param array<int> $pids
     * @param float $cpuUsage
     * @param float $memoryUsage
     */
    public function __construct(string $name, array $pids, float $cpuUsage, float $memoryUsage)
    {
        $this->name        = $name;
        $this->pids        = $pids;
        $this->cpuUsage    = $cpuUsage;
        $this->memoryUsage = $memoryUsage;
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * process name
     *
     * @var string
     */
    public readonly string $name;

    /**
     * pids
     *
     * @var array<int>
     */
    public readonly array $pids;

    /**
     * cpu usage percentage
     *
     * @var float
     */
    public readonly float $cpuUsage;

    /**
     * memory usage in bytes
     *
     * @var float
     */
    public readonly float $memoryUsage;

    /**
     * get pids count
     *
     * @return int
     */
    public function pidsCount(): int
    {
        return count($this->pids);
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
            "name"         => $this->name,
            "pids"         => $this->pids,
            "count"        => $this->pidsCount(),
            "cpu_usage"    => $this->cpuUsage,
            "memory_usage" => $this->memoryUsage,
        ];
    }
}
