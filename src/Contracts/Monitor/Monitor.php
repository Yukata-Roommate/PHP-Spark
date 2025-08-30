<?php

declare(strict_types=1);

namespace Spark\Contracts\Monitor;

use Spark\Contracts\Monitor\Metrics;

/**
 * Monitor Contract
 *
 * @package Spark\Contracts\Monitor
 */
interface Monitor
{
    /*----------------------------------------*
     * OS
     *----------------------------------------*/

    /**
     * Get os family
     *
     * @return string
     */
    public function os(): string;

    /**
     * Whether os is linux
     *
     * @return bool
     */
    public function isLinux(): bool;

    /**
     * Whether os is darwin
     *
     * @return bool
     */
    public function isDarwin(): bool;

    /**
     * Whether os is macOS
     *
     * @return bool
     */
    public function isMacOS(): bool;

    /*----------------------------------------*
     * Metrics
     *----------------------------------------*/

    /**
     * Get all metrics
     *
     * @return \Spark\Contracts\Monitor\Metrics
     */
    public function metrics(): Metrics;
}
