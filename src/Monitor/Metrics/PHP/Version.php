<?php

namespace Spark\Monitor\Metrics\PHP;

use Spark\Foundation\Monitor\Metrics\EmptiableMetrics;

/**
 * PHP Version
 *
 * @package Spark\Monitor\Metrics\PHP
 */
class Version extends EmptiableMetrics
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
     */
    public function __construct()
    {
        $this->version = phpversion();
        $this->id      = PHP_VERSION_ID;

        $versions = explode(".", $this->version);

        $this->majorVersion = (int)$versions[0] ?? 0;
        $this->minorVersion = (int)$versions[1] ?? 0;
        $this->patchVersion = (int)$versions[2] ?? 0;
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * php version
     *
     * @var string
     */
    protected string $version;

    /**
     * php version id
     *
     * @var int
     */
    protected int $id;

    /**
     * php major version
     *
     * @var int
     */
    protected int $majorVersion;

    /**
     * php minor version
     *
     * @var int
     */
    protected int $minorVersion;

    /**
     * php patch version
     *
     * @var int
     */
    protected int $patchVersion;

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
        return new self();
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
            "version" => $this->version,
            "id"      => $this->id,
            "major"   => $this->majorVersion,
            "minor"   => $this->minorVersion,
            "patch"   => $this->patchVersion,
        ];
    }
}
