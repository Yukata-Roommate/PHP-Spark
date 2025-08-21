<?php

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
     * get os family
     *
     * @return string
     */
    public function os(): string;

    /**
     * whether os is linux
     *
     * @return bool
     */
    public function isLinux(): bool;

    /**
     * whether os is darwin
     *
     * @return bool
     */
    public function isDarwin(): bool;

    /**
     * whether os is macOS
     *
     * @return bool
     */
    public function isMacOS(): bool;

    /*----------------------------------------*
     * Metrics
     *----------------------------------------*/

    /**
     * get all metrics
     *
     * @return \Spark\Contracts\Monitor\Metrics
     */
    public function metrics(): Metrics;
}
