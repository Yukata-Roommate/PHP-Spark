<?php

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
     * constructor
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
     * total php processes
     *
     * @var int
     */
    public readonly int $total;

    /**
     * php-fpm processes
     *
     * @var int
     */
    public readonly int $fpm;

    /**
     * php cli processes
     *
     * @var int
     */
    public readonly int $cli;

    /**
     * php cgi processes
     *
     * @var int
     */
    public readonly int $cgi;

    /**
     * php mod processes
     *
     * @var int
     */
    public readonly int $mod;

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
        return new self(0, 0, 0, 0, 0);
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
            "mod"   => $this->mod,
        ];
    }
}
