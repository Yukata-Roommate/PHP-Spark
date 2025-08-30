<?php

declare(strict_types=1);

namespace Spark\Contracts\File;

/**
 * File Operator Contract
 *
 * @package Spark\Contracts\File
 */
interface Operator extends Pathinfo
{
    /*----------------------------------------*
     * Create
     *----------------------------------------*/

    /**
     * Create file
     *
     * @param int|null $modificationTime
     * @param int|null $accessTime
     * @return bool
     * @throws \Spark\Exceptions\File\AlreadyExistsException
     * @throws \Spark\Exceptions\File\DirectoryCreateException
     */
    public function create(int|null $modificationTime = null, int|null $accessTime = null): bool;

    /**
     * Create file if not exists
     *
     * @param int|null $modificationTime
     * @param int|null $accessTime
     * @return bool
     */
    public function createIfNotExists(int|null $modificationTime = null, int|null $accessTime = null): bool;

    /**
     * Create directory
     *
     * @param int $permissions
     * @param bool $recursive
     * @return bool
     * @throws \Spark\Exceptions\File\DirectoryCreateException
     */
    public function createDirectory(int $permissions = 0755, bool $recursive = true): bool;

    /*----------------------------------------*
     * Remove
     *----------------------------------------*/

    /**
     * Remove file or directory
     *
     * @return bool
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\DeleteException
     */
    public function remove(): bool;

    /**
     * Remove file or directory recursively
     *
     * @return bool
     * @throws \Spark\Exceptions\File\DeleteException
     */
    public function removeRecursive(): bool;

    /*----------------------------------------*
     * Copy
     *----------------------------------------*/

    /**
     * Copy file
     *
     * @param string $destination
     * @param bool $overwrite
     * @return static|null
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\CopyException
     * @throws \Spark\Exceptions\File\AlreadyExistsException
     */
    public function copy(string $destination, bool $overwrite = false): static|null;

    /**
     * Create temporary copy of file
     *
     * @param string|null $tempDir
     * @param string|null $prefix
     * @return static|null
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\TempFileCreateException
     */
    public function copyTemporary(string|null $tempDir = null, string|null $prefix = null): static|null;

    /**
     * Create backup copy of file
     *
     * @param string|null $suffix
     * @param bool $timestamp
     * @return static|null
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\BackupCreateException
     */
    public function copyBackup(string|null $suffix = ".bak", bool $timestamp = false): static|null;

    /*----------------------------------------*
     * Move
     *----------------------------------------*/

    /**
     * Move file
     *
     * @param string $destination
     * @param bool $overwrite
     * @return static|null
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\MoveException
     * @throws \Spark\Exceptions\File\AlreadyExistsException
     */
    public function move(string $destination, bool $overwrite = false): static|null;

    /**
     * Rename file
     *
     * @param string $newName
     * @return static|null
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\MoveException
     */
    public function rename(string $newName): static|null;

    /*----------------------------------------*
     * Archive
     *----------------------------------------*/

    /**
     * Archive files to ZIP
     *
     * @param string|null $destination
     * @param string|null $password
     * @return static|null
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\ArchiveCreateException
     */
    public function archive(string|null $destination = null, string|null $password = null): static|null;

    /**
     * Extract archive
     *
     * @param string|null $destination
     * @param string|null $password
     * @return array<static>
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\ArchiveExtractException
     */
    public function extract(string|null $destination = null, string|null $password = null): array;

    /*----------------------------------------*
     * Permission
     *----------------------------------------*/

    /**
     * Change file permissions
     *
     * @param int|null $mode
     * @param string|null $owner
     * @param string|null $group
     * @return bool
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\PermissionChangeException
     */
    public function changePermissions(int|null $mode = null, string|null $owner = null, string|null $group = null): bool;

    /**
     * Change file mode
     *
     * @param int $mode
     * @return bool
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\PermissionChangeException
     */
    public function changeMode(int $mode): bool;

    /**
     * Change file owner
     *
     * @param string $owner
     * @return bool
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\PermissionChangeException
     */
    public function changeOwner(string $owner): bool;

    /**
     * Change file group
     *
     * @param string $group
     * @return bool
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\PermissionChangeException
     */
    public function changeGroup(string $group): bool;

    /*----------------------------------------*
     * Touch
     *----------------------------------------*/

    /**
     * Touch file
     *
     * @param int|null $modificationTime
     * @param int|null $accessTime
     * @return bool
     * @throws \Spark\Exceptions\File\NotFoundException
     */
    public function touch(int|null $modificationTime = null, int|null $accessTime = null): bool;

    /*----------------------------------------*
     * Lock
     *----------------------------------------*/

    /**
     * Lock file for exclusive access
     *
     * @param bool $blocking
     * @return bool
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\LockException
     */
    public function lock(bool $blocking = true): bool;

    /**
     * Unlock file
     *
     * @return bool
     * @throws \Spark\Exceptions\File\LockException
     */
    public function unlock(): bool;
}
