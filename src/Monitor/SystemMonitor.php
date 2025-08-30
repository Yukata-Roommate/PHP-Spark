<?php

declare(strict_types=1);

namespace Spark\Monitor;

use Spark\Contracts\Monitor\SystemMonitor as SystemMonitorContract;
use Spark\Foundation\Monitor\Monitor;

use Spark\Monitor\Metrics\System\CpuUsage;
use Spark\Monitor\Metrics\System\MemoryUsage;
use Spark\Monitor\Metrics\System\SwapMemory;
use Spark\Monitor\Metrics\System\DiskUsage;
use Spark\Monitor\Metrics\System\DiskIO;
use Spark\Monitor\Metrics\System\LoadAverage;
use Spark\Monitor\Metrics\System\Uptime;

use Spark\Monitor\Metrics\SystemMetrics;

/**
 * System Monitor
 *
 * @package Spark\Monitor
 */
class SystemMonitor extends Monitor implements SystemMonitorContract
{
    /*----------------------------------------*
     * CPU Usage
     *----------------------------------------*/

    /**
     * Get system cpu usage
     *
     * @return \Spark\Monitor\Metrics\System\CpuUsage
     */
    public function cpuUsage(): CpuUsage
    {
        return $this->switchByOs(
            fn() => $this->cpuUsageAtLinux(),
            fn() => $this->cpuUsageAtDarwin(),
        );
    }

    /**
     * Get system cpu usage at linux
     *
     * @return \Spark\Monitor\Metrics\System\CpuUsage
     */
    protected function cpuUsageAtLinux(): CpuUsage
    {
        $result = $this->exec("nproc");

        if ($result->isFailure(0)) return CpuUsage::empty();

        $total = (int)trim($result->outputAt(0));

        $result = $this->exec("top -bn1 | grep \"Cpu(s)\"");

        if ($result->isFailure(0)) return CpuUsage::empty();

        preg_match("/(\d+\.?\d*)[\s%]+id/", $result->outputAt(0), $matches);

        if (empty($matches[1])) return CpuUsage::empty();

        $idle = (float)$matches[1];

        $percentage = round(100 - $idle, 2);
        $used       = round($total * $percentage / 100, 2);
        $free       = round($total * $idle / 100, 2);

        return new CpuUsage($total, $used, $free, $percentage);
    }

    /**
     * Get system cpu usage at darwin
     *
     * @return \Spark\Monitor\Metrics\System\CpuUsage
     */
    protected function cpuUsageAtDarwin(): CpuUsage
    {
        $result = $this->exec("sysctl -n hw.ncpu");

        if ($result->isFailure(0)) return CpuUsage::empty();

        $total = (int)trim($result->outputAt(0));

        $result = $this->exec("top -l 1 | grep \"CPU usage\"");

        if ($result->isFailure(0)) return CpuUsage::empty();

        preg_match("/(\d+\.?\d*)% idle/", $result->outputAt(0), $matches);

        if (empty($matches[1])) return CpuUsage::empty();

        $idle = (float)$matches[1];

        $percentage = round(100 - $idle, 2);
        $used       = round($total * $percentage / 100, 2);
        $free       = round($total * $idle / 100, 2);

        return new CpuUsage($total, $used, $free, $percentage);
    }

    /*----------------------------------------*
     * Memory Usage
     *----------------------------------------*/

    /**
     * Get system memory usage
     *
     * @return \Spark\Monitor\Metrics\System\MemoryUsage
     */
    public function memoryUsage(): MemoryUsage
    {
        return $this->switchByOs(
            fn() => $this->memoryUsageAtLinux(),
            fn() => $this->memoryUsageAtDarwin(),
        );
    }

    /**
     * Get system memory usage at linux
     *
     * @return \Spark\Monitor\Metrics\System\MemoryUsage
     */
    protected function memoryUsageAtLinux(): MemoryUsage
    {
        $memoryInfo = @file_get_contents("/proc/meminfo");

        if (!$memoryInfo) return MemoryUsage::empty();

        preg_match("/MemTotal:\s+(\d+)/", $memoryInfo, $totalInfo);
        preg_match("/MemFree:\s+(\d+)/", $memoryInfo, $freeInfo);
        preg_match("/Buffers:\s+(\d+)/", $memoryInfo, $buffersInfo);
        preg_match("/Cached:\s+(\d+)/", $memoryInfo, $cachedInfo);

        $total   = (int)($totalInfo[1] ?? 0) * 1024;
        $free    = (int)($freeInfo[1] ?? 0) * 1024;
        $buffers = (int)($buffersInfo[1] ?? 0) * 1024;
        $cached  = (int)($cachedInfo[1] ?? 0) * 1024;

        $free = $free + $buffers + $cached;
        $used = $total - $free;

        $percentage = ($total > 0) ? ($used / $total) : 0.0;

        return new MemoryUsage(
            round($total, 2),
            round($used, 2),
            round($free, 2),
            round($percentage, 2)
        );
    }

    /**
     * Get system memory usage at darwin
     *
     * @return \Spark\Monitor\Metrics\System\MemoryUsage
     */
    protected function memoryUsageAtDarwin(): MemoryUsage
    {
        $result = $this->exec("vm_stat");

        if ($result->isFailure()) return MemoryUsage::empty();

        $vmstat = implode("\n", $result->output());

        preg_match("/page size of (\d+) bytes/", $vmstat, $pageSizeMatch);

        $pageSize = isset($pageSizeMatch[1]) ? (int)$pageSizeMatch[1] : 4096;

        preg_match("/Pages free:\s+(\d+)/", $vmstat, $freeInfo);
        preg_match("/Pages active:\s+(\d+)/", $vmstat, $activeInfo);
        preg_match("/Pages inactive:\s+(\d+)/", $vmstat, $inactiveInfo);
        preg_match("/Pages speculative:\s+(\d+)/", $vmstat, $specInfo);
        preg_match("/Pages wired down:\s+(\d+)/", $vmstat, $wiredInfo);

        $free     = (int)($freeInfo[1] ?? 0) * $pageSize;
        $active   = (int)($activeInfo[1] ?? 0) * $pageSize;
        $inactive = (int)($inactiveInfo[1] ?? 0) * $pageSize;
        $spec     = (int)($specInfo[1] ?? 0) * $pageSize;
        $wired    = (int)($wiredInfo[1] ?? 0) * $pageSize;

        $free       = $free + $inactive + $spec;
        $total      = $free + $active + $wired;
        $used       = $active + $wired;
        $percentage = ($total > 0) ? ($used / $total) : 0.0;

        return new MemoryUsage(
            round($total, 2),
            round($used, 2),
            round($free, 2),
            round($percentage, 2),
        );
    }

    /*----------------------------------------*
     * Swap Memory
     *----------------------------------------*/

    /**
     * Get system swap memory
     *
     * @return \Spark\Monitor\Metrics\System\SwapMemory
     */
    public function swapMemory(): SwapMemory
    {
        return $this->switchByOs(
            fn() => $this->swapMemoryAtLinux(),
            fn() => $this->swapMemoryAtDarwin(),
        );
    }

    /**
     * Get system swap memory at linux
     *
     * @return \Spark\Monitor\Metrics\System\SwapMemory
     */
    protected function swapMemoryAtLinux(): SwapMemory
    {
        $memoryInfo = @file_get_contents("/proc/meminfo");

        if (!$memoryInfo) return SwapMemory::empty();

        preg_match("/SwapTotal:\s+(\d+)/", $memoryInfo, $totalInfo);
        preg_match("/SwapFree:\s+(\d+)/", $memoryInfo, $freeInfo);

        $total = (int)($totalInfo[1] ?? 0) * 1024;
        $free  = (int)($freeInfo[1] ?? 0) * 1024;
        $used  = $total - $free;

        $percentage = ($total > 0) ? ($used / $total) : 0.0;

        return new SwapMemory(
            round($total, 2),
            round($used, 2),
            round($free, 2),
            round($percentage, 2)
        );
    }

    /**
     * Get system swap memory at darwin
     *
     * @return \Spark\Monitor\Metrics\System\SwapMemory
     */
    protected function swapMemoryAtDarwin(): SwapMemory
    {
        $result = $this->exec("sysctl vm.swapusage");

        if ($result->isFailure(0)) return SwapMemory::empty();

        $swapInfo = $result->outputAt(0);

        preg_match("/total = ([\d.]+)M/", $swapInfo, $totalInfo);
        preg_match("/used = ([\d.]+)M/", $swapInfo, $usedInfo);
        preg_match("/free = ([\d.]+)M/", $swapInfo, $freeInfo);

        $total = (float)($totalMatch[1] ?? 0) * 1024 * 1024;
        $used  = (float)($usedInfo[1] ?? 0) * 1024 * 1024;
        $free  = (float)($freeInfo[1] ?? 0) * 1024 * 1024;

        $percentage = ($total > 0) ? ($used / $total) : 0.0;

        return new SwapMemory(
            round($total, 2),
            round($used, 2),
            round($free, 2),
            round($percentage, 2)
        );
    }

    /*----------------------------------------*
     * Disk Usage
     *----------------------------------------*/

    /**
     * Get system disk usage
     *
     * @param string $path
     * @return \Spark\Monitor\Metrics\System\DiskUsage
     */
    public function diskUsage(string $path = "/"): DiskUsage
    {
        return $this->switchByOs(
            fn() => $this->diskUsageAtLinux($path),
            fn() => $this->diskUsageAtDarwin($path),
        );
    }

    /**
     * Get disk usage at linux
     *
     * @param string $path
     * @return \Spark\Monitor\Metrics\System\DiskUsage
     */
    protected function diskUsageAtLinux(string $path = "/"): DiskUsage
    {
        if (!file_exists($path)) return DiskUsage::empty();

        $total = @disk_total_space($path);
        $free  = @disk_free_space($path);

        if ($total === false || $free === false) return DiskUsage::empty();

        $used       = $total - $free;
        $percentage = $total > 0 ? ($used / $total) : 0.0;

        return new DiskUsage(
            round($total, 2),
            round($used, 2),
            round($free, 2),
            round($percentage, 2)
        );
    }

    /**
     * Get disk usage at darwin
     *
     * @param string $path
     * @return \Spark\Monitor\Metrics\System\DiskUsage
     */
    protected function diskUsageAtDarwin(string $path = "/"): DiskUsage
    {
        return $this->diskUsageAtLinux($path);
    }

    /*----------------------------------------*
     * Disk I/O
     *----------------------------------------*/

    /**
     * Get system disk I/O
     *
     * @param string $path
     * @return \Spark\Monitor\Metrics\System\DiskIO
     */
    public function diskIO(string $path = "/"): DiskIO
    {
        return $this->switchByOs(
            fn() => $this->diskIOAtLinux($path),
            fn() => $this->diskIOAtDarwin($path),
        );
    }

    /**
     * Get disk I/O at linux
     *
     * @param string $path
     * @return \Spark\Monitor\Metrics\System\DiskIO
     */
    protected function diskIOAtLinux(string $path = "/"): DiskIO
    {
        $result = $this->execWithArgs("df %s | tail -1 | awk \"{print $1}\"", [$path]);

        if ($result->isFailure(0)) return DiskIO::empty();

        $device = basename(trim($result->outputAt(0)));

        $result = $this->execWithArgs("iostat -dx %s 1 2 | tail -1", [$device]);

        if ($result->isFailure(0)) return DiskIO::empty();

        $iostatData = preg_split("/\s+/", trim($result->outputAt(0)));

        if (count($iostatData) < 14) return DiskIO::empty();

        $readSpeed   = (float)($iostatData[2] ?? 0) * 512 / 1024 / 1024;
        $writeSpeed  = (float)($iostatData[3] ?? 0) * 512 / 1024 / 1024;
        $readOps     = (int)($iostatData[2] ?? 0);
        $writeOps    = (int)($iostatData[3] ?? 0);
        $avgWaitTime = (float)($iostatData[9] ?? 0);
        $utilization = (float)($iostatData[13] ?? 0);

        return new DiskIO(
            round($readSpeed, 2),
            round($writeSpeed, 2),
            $readOps,
            $writeOps,
            round($avgWaitTime, 2),
            round($utilization, 2)
        );
    }

    /**
     * Get disk I/O at darwin
     *
     * @param string $path
     * @return \Spark\Monitor\Metrics\System\DiskIO
     */
    protected function diskIOAtDarwin(string $path = "/"): DiskIO
    {
        $result = $this->execWithArgs("df %s | tail -1 | awk \"{print $1}\"", [$path]);

        if ($result->isFailure(0)) return DiskIO::empty();

        $device = basename(trim($result->outputAt(0)));

        $result = $this->execWithArgs("iostat -d %s 1 2 | tail -1", [$device]);

        if ($result->isFailure(0)) return DiskIO::empty();

        $iostatData = preg_split("/\s+/", trim($result->outputAt(0)));

        if (count($iostatData) < 6) return DiskIO::empty();

        $readSpeed   = (float)($iostatData[2] ?? 0) / 1024 / 1024;
        $writeSpeed  = (float)($iostatData[3] ?? 0) / 1024 / 1024;
        $readOps     = (int)($iostatData[4] ?? 0);
        $writeOps    = (int)($iostatData[5] ?? 0);
        $avgWaitTime = (float)($iostatData[6] ?? 0);
        $utilization = (float)($iostatData[7] ?? 0);

        return new DiskIO(
            round($readSpeed, 2),
            round($writeSpeed, 2),
            $readOps,
            $writeOps,
            round($avgWaitTime, 2),
            round($utilization, 2)
        );
    }

    /*----------------------------------------*
     * Load Average
     *----------------------------------------*/

    /**
     * Get system load average
     *
     * @return \Spark\Monitor\Metrics\System\LoadAverage
     */
    public function loadAverage(): LoadAverage
    {
        return $this->switchByOs(
            fn() => $this->loadAverageAtLinux(),
            fn() => $this->loadAverageAtDarwin(),
        );
    }

    /**
     * Get system load average at linux
     *
     * @return \Spark\Monitor\Metrics\System\LoadAverage
     */
    protected function loadAverageAtLinux(): LoadAverage
    {
        $loadAverage = sys_getloadavg();

        if (!$loadAverage || count($loadAverage) < 3) return LoadAverage::empty();

        $oneMinute      = isset($loadAverage[0]) ? (float)$loadAverage[0] : 0.0;
        $fiveMinutes    = isset($loadAverage[1]) ? (float)$loadAverage[1] : 0.0;
        $fifteenMinutes = isset($loadAverage[2]) ? (float)$loadAverage[2] : 0.0;

        return new LoadAverage($oneMinute, $fiveMinutes, $fifteenMinutes);
    }

    /**
     * Get system load average at darwin
     *
     * @return \Spark\Monitor\Metrics\System\LoadAverage
     */
    protected function loadAverageAtDarwin(): LoadAverage
    {
        return $this->loadAverageAtLinux();
    }

    /*----------------------------------------*
     * Uptime
     *----------------------------------------*/

    /**
     * Get system uptime
     *
     * @return \Spark\Monitor\Metrics\System\Uptime
     */
    public function uptime(): Uptime
    {
        return $this->switchByOs(
            fn() => $this->uptimeAtLinux(),
            fn() => $this->uptimeAtDarwin(),
        );
    }

    /**
     * Get system uptime at linux
     *
     * @return \Spark\Monitor\Metrics\System\Uptime
     */
    protected function uptimeAtLinux(): Uptime
    {
        $uptimeInfo = @file_get_contents("/proc/uptime");

        if (!$uptimeInfo) return Uptime::empty();

        $uptime = (int)explode(" ", $uptimeInfo)[0];

        return new Uptime($uptime);
    }

    /**
     * Get system uptime at darwin
     *
     * @return \Spark\Monitor\Metrics\System\Uptime
     */
    protected function uptimeAtDarwin(): Uptime
    {
        $result = $this->exec("sysctl -n kern.boottime");

        if ($result->isFailure(0)) return Uptime::empty();

        preg_match("/sec = (\d+)/", $result->outputAt(0), $matches);

        if (empty($matches[1])) return Uptime::empty();

        $uptime = time() - (int)$matches[1];

        return new Uptime($uptime);
    }

    /*----------------------------------------*
     * Metrics
     *----------------------------------------*/

    /**
     * Get all metrics
     *
     * @return \Spark\Monitor\Metrics\SystemMetrics
     */
    public function metrics(): SystemMetrics
    {
        return new SystemMetrics(
            $this->cpuUsage(),
            $this->memoryUsage(),
            $this->swapMemory(),
            $this->diskUsage(),
            $this->diskIO(),
            $this->loadAverage(),
            $this->uptime(),
            $this->timestamp(),
        );
    }
}
