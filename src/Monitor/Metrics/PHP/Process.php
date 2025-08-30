<?php

declare(strict_types=1);

namespace Spark\Monitor\Metrics\PHP;

use Spark\Foundation\Monitor\Metrics\EmptiableMetrics;

/**
 * PHP Process
 *
 * @package Spark\Monitor\Metrics\PHP
 */
class Process extends EmptiableMetrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     *
     * @param int $total
     * @param int $fpm
     * @param int $cli
     * @param int $cgi
     * @param int $mod
     */
    public function __construct(int $total, int $fpm, int $cli, int $cgi, int $mod)
    {
        $this->total = $total;
        $this->fpm   = $fpm;
        $this->cli   = $cli;
        $this->cgi   = $cgi;
        $this->mod   = $mod;
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * Total php processes
     *
     * @var int
     */
    public readonly int $total;

    /**
     * Php-fpm processes
     *
     * @var int
     */
    public readonly int $fpm;

    /**
     * Php cli processes
     *
     * @var int
     */
    public readonly int $cli;

    /**
     * Php cgi processes
     *
     * @var int
     */
    public readonly int $cgi;

    /**
     * Php mod processes
     *
     * @var int
     */
    public readonly int $mod;

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
        return new self(0, 0, 0, 0, 0);
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
            "mod"   => $this->mod,
        ];
    }
}
