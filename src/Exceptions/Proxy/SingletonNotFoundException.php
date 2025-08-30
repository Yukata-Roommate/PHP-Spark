<?php

declare(strict_types=1);

namespace Spark\Exceptions\Proxy;

use Spark\Exceptions\Proxy\SingletonException;

/**
 * Singleton Not Found Exception
 *
 * @package Spark\Exceptions\Proxy
 */
class SingletonNotFoundException extends SingletonException
{
    /**
     * Singleton name
     *
     * @var string
     */
    protected string $singletonName;

    /**
     * Constructor
     *
     * @param string $singletonName
     */
    public function __construct(string $singletonName)
    {
        $this->singletonName = $singletonName;

        parent::__construct("Singleton instance \"{$singletonName}\" does not exist and no factory is registered.");
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
}
