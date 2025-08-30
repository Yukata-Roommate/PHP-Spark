<?php

declare(strict_types=1);

namespace Spark\Exceptions\Enum;

use Spark\Exceptions\Enum\ValueException;

/**
 * Invalid Index Exception
 *
 * @package Spark\Exceptions\Enum
 */
class InvalidIndexException extends ValueException
{
    /**
     * Enum class name
     *
     * @var string
     */
    protected string $className;

    /**
     * Invalid enum index
     *
     * @var int
     */
    protected int $index;

    /**
     * Count of enum cases
     *
     * @var int
     */
    protected int $count;

    /**
     * Constructor
     *
     * @param string $className
     * @param int $index
     * @param int $count
     */
    public function __construct(string $className, int $index, int $count)
    {
        $this->className = $className;
        $this->index     = $index;
        $this->count     = $count;

        parent::__construct("Index \"{$index}\" is out of bounds for enum {$className} with {$count} cases.");
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

    /**
     * Get invalid index
     *
     * @return int
     */
    public function index(): int
    {
        return $this->index;
    }

    /**
     * Get count of enum cases
     *
     * @return int
     */
    public function count(): int
    {
        return $this->count;
    }
}
