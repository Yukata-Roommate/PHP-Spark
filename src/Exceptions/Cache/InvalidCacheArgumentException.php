<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheConfigurationException;

/**
 * Invalid Cache Argument Exception
 *
 * @package Spark\Exceptions\Cache
 */
class InvalidCacheArgumentException extends CacheConfigurationException
{
    /**
     * The invalid argument name
     *
     * @var string|null
     */
    protected string|null $argumentName;

    /**
     * The invalid value
     *
     * @var mixed
     */
    protected mixed $invalidValue;

    /**
     * Constructor
     *
     * @param string $message
     * @param string|null $argumentName
     * @param mixed $invalidValue
     */
    public function __construct(
        string $message,
        string|null $argumentName = null,
        mixed $invalidValue = null
    ) {
        $this->argumentName = $argumentName;
        $this->invalidValue = $invalidValue;

        if ($argumentName !== null) $message = "Invalid argument \"$argumentName\": $message";

        parent::__construct($message);
    }

    /**
     * Get the argument name
     *
     * @return string|null
     */
    public function argumentName(): string|null
    {
        return $this->argumentName;
    }

    /**
     * Get the invalid value
     *
     * @return mixed
     */
    public function invalidValue(): mixed
    {
        return $this->invalidValue;
    }
}
