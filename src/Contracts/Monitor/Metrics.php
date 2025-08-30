<?php

declare(strict_types=1);

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
     * To array
     *
     * @return array
     */
    public function toArray(): array;
}
