<?php

declare(strict_types=1);

namespace Spark\Exceptions\Proxy;

use Spark\Exceptions\Proxy\SingletonException;

/**
 * Singleton Invalid Exception
 *
 * @package Spark\Exceptions\Proxy
 */
class SingletonInvalidException extends SingletonException
{
    /**
     * Singleton name
     *
     * @var string
     */
    protected string $singletonName;

    /**
     * Expected type
     *
     * @var string
     */
    protected string $expectedType;

    /**
     * Actual type
     *
     * @var string
     */
    protected string $actualType;

    /**
     * Value returned by factory
     *
     * @var mixed
     */
    protected mixed $returnedValue;

    /**
     * Constructor
     *
     * @param string $singletonName
     * @param string $expectedType
     * @param string $actualType
     * @param mixed $returnedValue
     */
    public function __construct(string $singletonName, string $expectedType, string $actualType, mixed $returnedValue)
    {
        $this->singletonName = $singletonName;
        $this->expectedType  = $expectedType;
        $this->actualType    = $actualType;
        $this->returnedValue = $returnedValue;

        parent::__construct("Singleton factory \"{$singletonName}\" must return {$expectedType}, {$actualType} returned.");
    }

    /**
     * Get singleton name
     *
     * @return string
     */
    public function singletonName(): string
    {
        return $this->singletonName;
    }

    /**
     * Get expected type
     *
     * @return string
     */
    public function expectedType(): string
    {
        return $this->expectedType;
    }

    /**
     * Get actual type
     *
     * @return string
     */
    public function actualType(): string
    {
        return $this->actualType;
    }

    /**
     * Get returned value
     *
     * @return mixed
     */
    public function returnedValue(): mixed
    {
        return $this->returnedValue;
    }
}
