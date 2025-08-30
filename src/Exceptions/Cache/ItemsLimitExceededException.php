<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CapacityException;

/**
 * Items Limit Exceeded Exception
 *
 * @package Spark\Exceptions\Cache
 */
class ItemsLimitExceededException extends CapacityException
{
    /**
     * Current items count
     *
     * @var int
     */
    protected int $currentCount;

    /**
     * Maximum allowed items
     *
     * @var int
     */
    protected int $maxItems;

    /**
     * Constructor
     *
     * @param int $currentCount
     * @param int $maxItems
     */
    public function __construct(int $currentCount, int $maxItems)
    {
        $this->currentCount = $currentCount;
        $this->maxItems     = $maxItems;

        parent::__construct("Items limit exceeded: current {$currentCount}, max {$maxItems}");
    }

    /**
     * Get current items count
     *
     * @return int
     */
    public function currentCount(): int
    {
        return $this->currentCount;
    }

    /**
     * Get maximum allowed items
     *
     * @return int
     */
    public function maxItems(): int
    {
        return $this->maxItems;
    }
}
