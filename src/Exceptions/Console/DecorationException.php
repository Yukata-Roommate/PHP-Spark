<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\OutputException;

/**
 * Decoration Exception
 *
 * @package Spark\Exceptions\Console
 */
class DecorationException extends OutputException
{
    /**
     * Invalid decoration code
     *
     * @var int
     */
    protected int $decorationCode;

    /**
     * Constructor
     *
     * @param int $decorationCode
     */
    public function __construct(int $decorationCode)
    {
        $this->decorationCode = $decorationCode;

        parent::__construct("Invalid decoration code: {$decorationCode}");
    }

    /**
     * Get decoration code
     *
     * @return int
     */
    public function decorationCode(): int
    {
        return $this->decorationCode;
    }
}
