<?php

namespace Spark\Contracts\Monitor;

/**
 * Monitor Metrics Contract
 *
 * @package Spark\Contracts\Monitor
 */
interface Metrics
{
    /*----------------------------------------*
     * To Array
     *----------------------------------------*/

    /**
     * to array
     *
     * @return array
     */
    public function toArray(): array;
}
