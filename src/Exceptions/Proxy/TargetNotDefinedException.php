<?php

declare(strict_types=1);

namespace Spark\Exceptions\Proxy;

use Spark\Exceptions\Proxy\TargetException;

/**
 * Target Not Defined Exception
 *
 * @package Spark\Exceptions\Proxy
 */
class TargetNotDefinedException extends TargetException
{
    /**
     * Class missing proxy target
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

        parent::__construct("Proxy target is not defined in class \"{$className}\". Please define \$proxyTarget property.");
    }

    /**
     * Get class name
     *
     * @return string
     */
    public function className(): string
    {
        return $this->className;
    }
}
