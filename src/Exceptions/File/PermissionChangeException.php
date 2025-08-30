<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\OperationException;

/**
 * Permission Change Exception
 *
 * @package Spark\Exceptions\File
 */
class PermissionChangeException extends OperationException
{
    /**
     * File path
     *
     * @var string
     */
    protected string $path;

    /**
     * Permission type
     *
     * @var string
     */
    protected string $permissionType;

    /**
     * Constructor
     *
     * @param string $path
     * @param string $permissionType
     */
    public function __construct(string $path, string $permissionType)
    {
        $this->path           = $path;
        $this->permissionType = $permissionType;

        parent::__construct("Failed to change {$permissionType} for file: \"{$path}\"");
    }

    /**
     * Get file path
     *
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * Get permission type
     *
     * @return string
     */
    public function permissionType(): string
    {
        return $this->permissionType;
    }
}
