<?php

declare(strict_types=1);

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
     * Constructor
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
     * Process name
     *
     * @var string
     */
    public readonly string $name;

    /**
     * Pids
     *
     * @var array<int>
     */
    public readonly array $pids;

    /**
     * Cpu usage percentage
     *
     * @var float
     */
    public readonly float $cpuUsage;

    /**
     * Memory usage in bytes
     *
     * @var float
     */
    public readonly float $memoryUsage;

    /**
     * Get pids count
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
     * To array
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
