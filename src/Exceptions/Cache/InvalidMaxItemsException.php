<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\ConfigurationException;

/**
 * Invalid Max Items Exception
 *
 * @package Spark\Exceptions\Cache
 */
class InvalidMaxItemsException extends ConfigurationException
{
    /**
     * Invalid max items value
     *
     * @var int
     */
    protected int $maxItems;

    /**
     * Constructor
     *
     * @param int $maxItems
     */
    public function __construct(int $maxItems)
    {
        $this->maxItems = $maxItems;

        parent::__construct("Max items must be positive, got {$maxItems}");
    }

    /**
     * Get invalid max items value
     *
     * @return int
     */
    public function maxItems(): int
    {
        return $this->maxItems;
    }
}
