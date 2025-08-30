<?php

declare(strict_types=1);

namespace Spark\Monitor\Metrics\PHP;

use Spark\Foundation\Monitor\Metrics\EmptiableMetrics;

/**
 * PHP CPU Usage
 *
 * @package Spark\Monitor\Metrics\PHP
 */
class CpuUsage extends EmptiableMetrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     *
     * @param float $total
     * @param float $fpm
     * @param float $cli
     * @param float $cgi
     */
    public function __construct(float $total, float $fpm, float $cli, float $cgi)
    {
        $this->total = $total;
        $this->fpm   = $fpm;
        $this->cli   = $cli;
        $this->cgi   = $cgi;
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * Total php cpu usage
     *
     * @var float
     */
    public float $total;

    /**
     * Php-fpm cpu usage
     *
     * @var float
     */
    public float $fpm;

    /**
     * Php-cli cpu usage
     *
     * @var float
     */
    public float $cli;

    /**
     * Php-cgi cpu usage
     *
     * @var float
     */
    public float $cgi;

    /*----------------------------------------*
     * Emptiable
     *----------------------------------------*/

    /**
     * Make empty
     *
     * @return static
     */
    public static function empty(): static
    {
        return new self(0.0, 0.0, 0.0, 0.0);
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
            "total" => $this->total,
            "fpm"   => $this->fpm,
            "cli"   => $this->cli,
            "cgi"   => $this->cgi,
            "formatted"  => [
                "total" => $this->formatPercentage($this->total),
                "fpm"   => $this->formatPercentage($this->fpm),
                "cli"   => $this->formatPercentage($this->cli),
                "cgi"   => $this->formatPercentage($this->cgi),
            ],
        ];
    }
}
