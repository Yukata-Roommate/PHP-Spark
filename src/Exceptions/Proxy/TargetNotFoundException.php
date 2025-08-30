<?php

declare(strict_types=1);

namespace Spark\Exceptions\Proxy;

use Spark\Exceptions\Proxy\TargetException;

/**
 * Target Not Found Exception
 *
 * @package Spark\Exceptions\Proxy
 */
class TargetNotFoundException extends TargetException
{
    /**
     * Target class name
     *
     * @var string
     */
    protected string $className;

    /**
     * Constructor
     *
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;

        parent::__construct("Proxy target class \"{$className}\" does not exist.");
    }

    /**
     * Get target class name
     *
     * @return string
     */
    public function className(): string
    {
        return $this->className;
    }
}
