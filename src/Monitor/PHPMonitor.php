<?php

declare(strict_types=1);

namespace Spark\Monitor;

use Spark\Contracts\Monitor\PHPMonitor as PHPMonitorContract;
use Spark\Foundation\Monitor\Monitor;

use Spark\Monitor\Metrics\PHP\Version;
use Spark\Monitor\Metrics\PHP\Process;
use Spark\Monitor\Metrics\PHP\CpuUsage;
use Spark\Monitor\Metrics\PHP\MemoryUsage;

use Spark\Monitor\Metrics\PHPMetrics;

/**
 * PHP Monitor
 *
 * @package Spark\Monitor
 */
class PHPMonitor extends Monitor implements PHPMonitorContract
{
    /*----------------------------------------*
     * Version
     *----------------------------------------*/

    /**
     * Get php version
     *
     * @return \Spark\Monitor\Metrics\PHP\Version
     */
    public function version(): Version
    {
        return new Version();
    }

    /*----------------------------------------*
     * Process
     *----------------------------------------*/

    /**
     * Get php process
     *
     * @return \Spark\Monitor\Metrics\PHP\Process
     */
    public function process(): Process
    {
        return $this->switchByOs(
            fn() => $this->processAtLinux(),
            fn() => $this->processAtDarwin(),
        );
    }

    /**
     * Get php process at linux
     *
     * @return \Spark\Monitor\Metrics\PHP\Process
     */
    protected function processAtLinux(): Process
    {
        $fpmResult = $this->exec("pgrep -c \"php-fpm\"");
        $fpm       = $fpmResult->isSuccess() ? (int)trim($fpmResult->outputAt(0)) : 0;

        $cliResult = $this->exec("ps aux | grep -E \"^[^ ]+ +[0-9]+ .* Php \" | grep -v \"php-fpm\\|php-cgi\\|grep\" | wc -l");
        $cli       = $cliResult->isSuccess() ? (int)trim($cliResult->outputAt(0)) : 0;

        $cgiResult = $this->exec("pgrep -c \"php-cgi\"");
        $cgi       = $cgiResult->isSuccess() ? (int)trim($cgiResult->outputAt(0)) : 0;

        $mod = $this->isServiceRunning("apache2") || $this->isServiceRunning("httpd") ? 1 : 0;

        $total = $fpm + $cli + $cgi + $mod;

        return new Process($total, $fpm, $cli, $cgi, $mod);
    }

    /**
     * Get php process at darwin
     *
     * @return \Spark\Monitor\Metrics\PHP\Process
     */
    protected function processAtDarwin(): Process
    {
        return $this->processAtLinux();
    }

    /*----------------------------------------*
     * CPU Usage
     *----------------------------------------*/

    /**
     * Get php cpu usage
     *
     * @return \Spark\Monitor\Metrics\PHP\CpuUsage
     */
    public function cpuUsage(): CpuUsage
    {
        return $this->switchByOs(
            fn() => $this->cpuUsageAtLinux(),
            fn() => $this->cpuUsageAtDarwin(),
        );
    }

    /**
     * Get php cpu usage at linux
     *
     * @return \Spark\Monitor\Metrics\PHP\CpuUsage
     */
    protected function cpuUsageAtLinux(): CpuUsage
    {
        $fpm = $this->getTotalCpuUsageByName("php-fpm");
        $cli = $this->getTotalCpuUsage($this->getPhpCliPids());
        $cgi = $this->getTotalCpuUsageByName("php-cgi");

        $total = round($fpm + $cli + $cgi, 2);

        return new CpuUsage($total, $fpm, $cli, $cgi);
    }

    /**
     * Get php cpu usage at darwin
     *
     * @return \Spark\Monitor\Metrics\PHP\CpuUsage
     */
    protected function cpuUsageAtDarwin(): CpuUsage
    {
        return $this->cpuUsageAtLinux();
    }

    /*----------------------------------------*
     * Memory Usage
     *----------------------------------------*/

    /**
     * Get php memory usage
     *
     * @return \Spark\Monitor\Metrics\PHP\MemoryUsage
     */
    public function memoryUsage(): MemoryUsage
    {
        return $this->switchByOs(
            fn() => $this->memoryUsageAtLinux(),
            fn() => $this->memoryUsageAtDarwin(),
        );
    }

    /**
     * Get php memory usage at linux
     *
     * @return \Spark\Monitor\Metrics\PHP\MemoryUsage
     */
    protected function memoryUsageAtLinux(): MemoryUsage
    {
        $fpm = $this->getTotalMemoryUsageByName("php-fpm");
        $cli = $this->getTotalMemoryUsage($this->getPhpCliPids());
        $cgi = $this->getTotalMemoryUsageByName("php-cgi");

        $total = round($fpm + $cli + $cgi, 2);

        return new MemoryUsage($total, $fpm, $cli, $cgi);
    }

    /**
     * Get php memory usage at darwin
     *
     * @return \Spark\Monitor\Metrics\PHP\MemoryUsage
     */
    protected function memoryUsageAtDarwin(): MemoryUsage
    {
        return $this->memoryUsageAtLinux();
    }

    /*----------------------------------------*
     * Metrics
     *----------------------------------------*/

    /**
     * Get all metrics
     *
     * @return \Spark\Monitor\Metrics\PHPMetrics
     */
    public function metrics(): PHPMetrics
    {
        return new PHPMetrics(
            $this->version(),
            $this->process(),
            $this->cpuUsage(),
            $this->memoryUsage(),
            $this->timestamp()
        );
    }

    /*----------------------------------------*
     * Pids
     *----------------------------------------*/

    /**
     * Get PHP CLI process PIDs
     *
     * @return array<int>
     */
    protected function getPhpCliPids(): array
    {
        $pids = [];

        $result = $this->exec("ps aux | grep -E \"^[^ ]+ +[0-9]+ .* Php \" | grep -v \"php-fpm\\|php-cgi\\|grep\" | awk \"{print $2}\"");

        if ($result->isFailure()) return $pids;

        foreach ($result->outputIterate() as $line) {
            $pid = trim($line);

            if (!is_numeric($pid)) continue;

            if ((int)$pid <= 0) continue;

            $pids[] = (int)$pid;
        }

        return $pids;
    }
}
