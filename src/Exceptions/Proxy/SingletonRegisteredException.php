<?php

declare(strict_types=1);

namespace Spark\Exceptions\Proxy;

use Spark\Exceptions\Proxy\SingletonException;

/**
 * Singleton Registered Exception
 *
 * @package Spark\Exceptions\Proxy
 */
class SingletonRegisteredException extends SingletonException
{
    /**
     * Singleton name
     *
     * @var string
     */
    protected string $singletonName;

    /**
     * Type of existing registration
     *
     * @var string
     */
    protected string $existingType;

    /**
     * Constructor
     *
     * @param string $singletonName
     * @param string $existingType
     */
    public function __construct(string $singletonName, string $existingType)
    {
        $this->singletonName = $singletonName;
        $this->existingType  = $existingType;

        parent::__construct("Singleton \"{$singletonName}\" is already registered as {$existingType} and cannot be overwritten.");
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
     * Get existing type
     *
     * @return string
     */
    public function existingType(): string
    {
        return $this->existingType;
    }
}
