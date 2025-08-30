<?php

declare(strict_types=1);

namespace Spark\Foundation\Monitor;

use Spark\Contracts\Monitor\Monitor as MonitorContract;

use Spark\Contracts\Monitor\Metrics;

use Spark\Monitor\Exec\CommandResult;
use Spark\Monitor\Metrics\ProcessMetrics;

/**
 * Monitor
 *
 * @package Spark\Foundation\Monitor
 */
abstract class Monitor implements MonitorContract
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->os = PHP_OS_FAMILY;

        $this->isLinux  = $this->os === "Linux";
        $this->isDarwin = $this->os === "Darwin";
    }

    /*----------------------------------------*
     * OS
     *----------------------------------------*/

    /**
     * Os family
     *
     * @var string
     */
    protected string $os;

    /**
     * Whether os is linux
     *
     * @var bool
     */
    protected bool $isLinux;

    /**
     * Whether os is darwin
     *
     * Var bool
     */
    protected bool $isDarwin;

    /**
     * Get os family
     *
     * @return string
     */
    public function os(): string
    {
        return $this->os;
    }

    /**
     * Whether os is linux
     *
     * @return bool
     */
    public function isLinux(): bool
    {
        return $this->isLinux;
    }

    /**
     * Whether os is darwin
     *
     * @return bool
     */
    public function isDarwin(): bool
    {
        return $this->isDarwin;
    }

    /**
     * Whether os is macOS
     *
     * @return bool
     */
    public function isMacOS(): bool
    {
        return $this->isDarwin();
    }

    /**
     * Switch method by os
     *
     * @param callable $linuxMethod
     * @param callable $darwinMethod
     * @return mixed
     */
    protected function switchByOs(callable $linuxMethod, callable $darwinMethod): mixed
    {
        return match (true) {
            $this->isLinux()  => $linuxMethod(),
            $this->isDarwin() => $darwinMethod(),

            default => throw new \RuntimeException("Unsupported OS: {$this->os}"),
        };
    }

    /*----------------------------------------*
     * Exec
     *----------------------------------------*/

    /**
     * Execute command
     *
     * @param string $command
     * @return \Spark\Monitor\Exec\CommandResult
     */
    protected function exec(string $command): CommandResult
    {
        $output = [];
        $code   = 0;

        $safeCommand = escapeshellcmd($command);

        exec("{$safeCommand} 2>&1", $output, $code);

        return new CommandResult($output, $code);
    }

    /**
     * Execute command with arguments
     *
     * @param string $command
     * @param array $args
     * @return \Spark\Monitor\Exec\CommandResult
     */
    protected function execWithArgs(string $command, array $args = []): CommandResult
    {
        $safeArgs    = array_map("escapeshellarg", $args);
        $safeCommand = vsprintf($command, $safeArgs);

        return $this->exec($safeCommand);
    }

    /*----------------------------------------*
     * Pids
     *----------------------------------------*/

    /**
     * Get pids by process name
     *
     * @param string $name
     * @return array<int>
     */
    protected function getPids(string $name): array
    {
        return $this->switchByOs(
            fn() => $this->getPidsAtLinux($name),
            fn() => $this->getPidsAtDarwin($name)
        );
    }

    /**
     * Get pids by process name at linux
     *
     * @param string $name
     * @return array<int>
     */
    protected function getPidsAtLinux(string $name): array
    {
        $pids = [];

        $result = $this->execWithArgs("pgrep -f %s", [$name]);

        if ($result->isFailure()) return $pids;

        foreach ($result->outputIterate() as $line) {
            $pid = trim($line);

            if (!is_numeric($pid)) continue;

            $pids[] = (int)$pid;
        }

        return $pids;
    }

    /**
     * Get pids by process name at darwin
     *
     * @param string $name
     * @return array<int>
     */
    protected function getPidsAtDarwin(string $name): array
    {
        return $this->getPidsAtLinux($name);
    }

    /*----------------------------------------*
     * CPU Usage
     *----------------------------------------*/

    /**
     * Get cpu usage percentage by pid
     *
     * @param int $pid
     * @return float
     */
    protected function getCpuUsage(int $pid): float
    {
        return $this->switchByOs(
            fn() => $this->getCpuUsageAtLinux($pid),
            fn() => $this->getCpuUsageAtDarwin($pid)
        );
    }

    /**
     * Get cpu usage percentage at linux
     *
     * @param int $pid
     * @return float
     */
    protected function getCpuUsageAtLinux(int $pid): float
    {
        if ($pid <= 0) return 0.0;

        $result = $this->execWithArgs("ps -p %d -o %%cpu --no-headers", [$pid]);

        if ($result->isFailure(0)) return 0.0;

        $usage = (float)trim($result->outputAt(0)) ?: 0.0;

        return round($usage, 2);
    }

    /**
     * Get cpu usage percentage at darwin
     *
     * @param int $pid
     * @return float
     */
    protected function getCpuUsageAtDarwin(int $pid): float
    {
        if ($pid <= 0) return 0.0;

        $result = $this->execWithArgs("ps -p %d -o %%cpu", [$pid]);

        if ($result->isFailure(1)) return 0.0;

        $usage = (float)trim($result->outputAt(1)) ?: 0.0;

        return round($usage, 2);
    }

    /**
     * Get total cpu usages by pids
     *
     * @param array<int> $pids
     * @return float
     */
    protected function getTotalCpuUsage(array $pids): float
    {
        $totalUsage = 0.0;

        if (empty($pids)) return $totalUsage;

        foreach ($pids as $pid) {
            $totalUsage += $this->getCpuUsage($pid);
        }

        return round($totalUsage, 2);
    }

    /**
     * Get total cpu usage by process name
     *
     * @param string $name
     * @return float
     */
    protected function getTotalCpuUsageByName(string $name): float
    {
        $pids = $this->getPids($name);

        return $this->getTotalCpuUsage($pids);
    }

    /*----------------------------------------*
     * Memory Usage
     *----------------------------------------*/

    /**
     * Get memory usage in bytes by pid
     *
     * @param int $pid
     * @return float
     */
    protected function getMemoryUsage(int $pid): float
    {
        return $this->switchByOs(
            fn() => $this->getMemoryUsageAtLinux($pid),
            fn() => $this->getMemoryUsageAtDarwin($pid)
        );
    }

    /**
     * Get memory usage in bytes at linux
     *
     * @param int $pid
     * @return float
     */
    protected function getMemoryUsageAtLinux(int $pid): float
    {
        if ($pid <= 0) return 0.0;

        $statusFile = "/proc/{$pid}/status";

        if (!file_exists($statusFile) || !is_readable($statusFile)) return 0.0;

        $status = @file_get_contents($statusFile);

        if ($status === false) return 0.0;

        if (!preg_match("/VmRSS:\s+(\d+)\s+kB/", $status, $matches)) return 0.0;

        $memory = (float)$matches[1];

        return round($memory * 1024, 2);
    }

    /**
     * Get memory usage in bytes at darwin
     *
     * @param int $pid
     * @return float
     */
    protected function getMemoryUsageAtDarwin(int $pid): float
    {
        if ($pid <= 0) return 0.0;

        $result = $this->execWithArgs("ps -p %d -o rss", [$pid]);

        if ($result->isFailure(1)) return 0.0;

        $memory = (float)trim($result->outputAt(1));

        return round($memory * 1024, 2);
    }

    /**
     * Get total memory usage by pids
     *
     * @param array<int> $pids
     * @return float
     */
    protected function getTotalMemoryUsage(array $pids): float
    {
        $totalMemory = 0.0;

        if (empty($pids)) return $totalMemory;

        foreach ($pids as $pid) {
            $totalMemory += $this->getMemoryUsage($pid);
        }

        return $totalMemory;
    }

    /**
     * Get total memory usage by process name
     *
     * @param string $name
     * @return float
     */
    protected function getTotalMemoryUsageByName(string $name): float
    {
        $pids = $this->getPids($name);

        return $this->getTotalMemoryUsage($pids);
    }

    /*----------------------------------------*
     * Service
     *----------------------------------------*/

    /**
     * Whether service is running
     *
     * @param string $name
     * @return bool
     */
    protected function isServiceRunning(string $name): bool
    {
        return $this->switchByOs(
            fn() => $this->isServiceRunningAtLinux($name),
            fn() => $this->isServiceRunningAtDarwin($name)
        );
    }

    /**
     * Whether service is running at linux
     *
     * @param string $name
     * @return bool
     */
    protected function isServiceRunningAtLinux(string $name): bool
    {
        if (!preg_match("/^[a-zA-Z0-9._-]+$/", $name)) return false;

        $result = $this->execWithArgs("systemctl is-active %s", [$name]);

        if ($result->isFailure(0)) return false;

        return trim($result->outputAt(0)) === "active";
    }

    /**
     * Whether service is running at darwin
     *
     * @param string $name
     * @return bool
     */
    protected function isServiceRunningAtDarwin(string $name): bool
    {
        if (!preg_match("/^[a-zA-Z0-9._-]+$/", $name)) return false;

        $result = $this->execWithArgs("pgrep -x %s", [$name]);

        return $result->isSuccess();
    }

    /*----------------------------------------*
     * Metric
     *----------------------------------------*/

    /**
     * Get all metrics
     *
     * @return \Spark\Contracts\Monitor\Metrics
     */
    abstract public function metrics(): Metrics;

    /**
     * Get timestamp
     *
     * @return string
     */
    protected function timestamp(): string
    {
        return date("Y-m-d H:i:s");
    }

    /**
     * Get process metrics by name
     *
     * @param string $name
     * @return \Spark\Monitor\Metrics\ProcessMetrics
     */
    protected function getProcessMetrics(string $name): ProcessMetrics
    {
        $pids = $this->getPids($name);

        $cpuUsage    = $this->getTotalCpuUsage($pids);
        $memoryUsage = $this->getTotalMemoryUsage($pids);

        return new ProcessMetrics($name, $pids, $cpuUsage, $memoryUsage);
    }
}
