<?php

declare(strict_types=1);

namespace Spark\Foundation\Monitor\Metrics;

use Spark\Foundation\Monitor\Metrics\Metrics;

/**
 * Emptiable Metrics
 *
 * @package Spark\Foundation\Monitor\Metrics
 */
abstract class EmptiableMetrics extends Metrics
{
    /*----------------------------------------*
     * Emptiable
     *----------------------------------------*/

    /**
     * Make empty
     *
     * @return static
     */
    abstract public static function empty(): static;
}
