<?php

namespace Spark\Monitor\Metrics\PHP;

use Spark\Foundation\Monitor\Metrics\EmptiableMetrics;

/**
 * PHP Memory Usage
 *
 * @package Spark\Monitor\Metrics\PHP
 */
class MemoryUsage extends EmptiableMetrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
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
     * total php memory usage
     *
     * @var float
     */
    public float $total;

    /**
     * php-fpm memory usage
     *
     * @var float
     */
    public float $fpm;

    /**
     * php-cli memory usage
     *
     * @var float
     */
    public float $cli;

    /**
     * php-cgi memory usage
     *
     * @var float
     */
    public float $cgi;

    /*----------------------------------------*
     * Emptiable
     *----------------------------------------*/

    /**
     * make empty
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
     * to array
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
                "total" => $this->formatBytes($this->total),
                "fpm"   => $this->formatBytes($this->fpm),
                "cli"   => $this->formatBytes($this->cli),
                "cgi"   => $this->formatBytes($this->cgi),
            ],
        ];
    }
}
