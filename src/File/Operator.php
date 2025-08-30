<?php

declare(strict_types=1);

namespace Spark\File;

use Spark\Contracts\File\Operator as OperatorContract;

use Spark\Exceptions\File\AlreadyExistsException;
use Spark\Exceptions\File\NotFoundException;
use Spark\Exceptions\File\CopyException;
use Spark\Exceptions\File\MoveException;
use Spark\Exceptions\File\DeleteException;
use Spark\Exceptions\File\LockException;
use Spark\Exceptions\File\DirectoryCreateException;
use Spark\Exceptions\File\PermissionChangeException;
use Spark\Exceptions\File\TempFileCreateException;
use Spark\Exceptions\File\BackupCreateException;
use Spark\Exceptions\File\ArchiveCreateException;
use Spark\Exceptions\File\ArchiveExtractException;

use ZipArchive;

/**
 * File Operator
 *
 * @package Spark\File
 */
class Operator extends Pathinfo implements OperatorContract
{
    /*----------------------------------------*
     * Destructor
     *----------------------------------------*/

    /**
     * Destructor
     */
    public function __destruct()
    {
        $this->unlock();
    }

    /*----------------------------------------*
     * Create
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function create(int|null $modificationTime = null, int|null $accessTime = null): bool
    {
        if ($this->exists()) throw new AlreadyExistsException($this->path);

        if (!$this->parentExists()) $this->createParentDirectory();

        $result = match (true) {
            $modificationTime === null => @touch($this->path),
            $accessTime       === null => @touch($this->path, $modificationTime),

            default => @touch($this->path, $modificationTime, $accessTime),
        };

        if (!$result) {
            $error = error_get_last();

            throw new DirectoryCreateException($this->path, $error ? $error["message"] : "Unknown error");
        }

        $this->clearCache();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function createIfNotExists(int|null $modificationTime = null, int|null $accessTime = null): bool
    {
        if ($this->exists()) return true;

        try {
            return $this->create($modificationTime, $accessTime);
        } catch (AlreadyExistsException $e) {
            return true;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function createDirectory(int $permissions = 0755, bool $recursive = true): bool
    {
        if ($this->isDirectory()) return true;

        if ($this->exists() && !$this->isDirectory()) throw new DirectoryCreateException($this->path, "Path exists but is not directory");

        $result = @mkdir($this->path, $permissions, $recursive);

        if (!$result && !$this->isDirectory()) {
            $error = error_get_last();

            throw new DirectoryCreateException($this->path, $error ? $error["message"] : "Unknown error");
        }

        $this->clearCache();

        return true;
    }

    /**
     * Create parent directory if not exists
     *
     * @return bool
     * @throws \Spark\Exceptions\File\DirectoryCreateException
     */
    protected function createParentDirectory(): bool
    {
        $dirname = $this->dirname();

        if ($dirname === "" || $dirname === ".") return true;

        $parent = new static($dirname);

        return $parent->createDirectory();
    }

    /*----------------------------------------*
     * Remove
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function remove(): bool
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        if ($this->isDirectory()) {
            $result = @rmdir($this->path);
        } else {
            $result = @unlink($this->path);
        }

        if (!$result) {
            $error = error_get_last();

            throw new DeleteException($this->path, $error ? $error["message"] : "Unknown error");
        }

        $this->clearCache();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function removeRecursive(): bool
    {
        if (!$this->exists()) return true;

        if (!$this->isDirectory()) {
            try {
                return $this->remove();
            } catch (NotFoundException $e) {
                return true;
            }
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $fileInfo) {
            $file = new static($fileInfo->getPathname());

            try {
                $file->remove();
            } catch (NotFoundException $e) {
                continue;
            } catch (\Exception $e) {
                throw new DeleteException($fileInfo->getPathname(), $e->getMessage());
            }
        }

        try {
            return $this->remove();
        } catch (NotFoundException $e) {
            return true;
        }
    }

    /*----------------------------------------*
     * Copy
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function copy(string $destination, bool $overwrite = false): static|null
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        $copy = new static($destination);

        if ($copy->exists() && !$overwrite) throw new AlreadyExistsException($destination);

        if (!$copy->parentExists()) $copy->createParentDirectory();

        $this->beginTransaction("copy", $this->path, $destination);

        try {
            $result = @copy($this->path, $copy->path());

            if (!$result) {
                $error = error_get_last();

                throw new CopyException($this->path, $destination, $error ? $error["message"] : "Unknown error");
            }

            if (!$this->isWindows()) {
                $perms = fileperms($this->path);

                if ($perms !== false) @chmod($destination, $perms);
            }

            $this->commitTransaction();

            return $copy;
        } catch (\Exception $e) {
            $this->rollbackTransaction();

            throw $e;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function copyTemporary(string|null $tempDir = null, string|null $prefix = null): static|null
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        $tempDir = $tempDir ?? sys_get_temp_dir();
        $prefix  = $prefix ?? "spark_";

        $tempPath = tempnam($tempDir, $prefix);

        if ($tempPath === false) throw new TempFileCreateException($tempDir, $prefix);

        $extension = $this->extension();

        if ($extension !== null) {
            $newTempPath = $tempPath . "." . $extension;

            @rename($tempPath, $newTempPath);

            $tempPath = $newTempPath;
        }

        try {
            $temp = new static($tempPath);

            if (!@copy($this->path, $tempPath)) throw new TempFileCreateException($tempDir, $prefix);

            return $temp;
        } catch (TempFileCreateException $e) {
            @unlink($tempPath);

            throw $e;
        } catch (\Exception $e) {
            @unlink($tempPath);

            throw new TempFileCreateException($tempDir, $prefix);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function copyBackup(string|null $suffix = ".bak", bool $timestamp = false): static|null
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        $backupPath = $this->path;

        if ($timestamp) $backupPath .= "." . date("YmdHis");

        $backupPath .= $suffix;

        try {
            return $this->copy($backupPath, false);
        } catch (\Exception $e) {
            throw new BackupCreateException($this->path, $backupPath);
        }
    }

    /*----------------------------------------*
     * Move
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function move(string $destination, bool $overwrite = false): static|null
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        $move = new static($destination);

        if ($move->exists() && !$overwrite) throw new AlreadyExistsException($destination);

        if (!$move->parentExists()) $move->createParentDirectory();

        $this->beginTransaction("move", $this->path, $destination);

        try {
            if ($move->exists() && $overwrite) $move->remove();

            $result = @rename($this->path, $move->path());

            if (!$result) {
                $error = error_get_last();

                throw new MoveException($this->path, $destination, $error ? $error["message"] : "Unknown error");
            }

            $this->setPath($destination);

            $this->commitTransaction();

            return $this;
        } catch (\Exception $e) {
            $this->rollbackTransaction();

            throw $e;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function rename(string $newName): static|null
    {
        $destination = $this->dirname() . DIRECTORY_SEPARATOR . $newName;

        return $this->move($destination);
    }

    /*----------------------------------------*
     * Archive
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function archive(string|null $destination = null, string|null $password = null): static|null
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        $destination = $destination ?? $this->path . ".zip";

        if (!class_exists("ZipArchive")) throw new ArchiveCreateException($this->path, $destination);

        $zip = new ZipArchive();

        $result = $zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        if ($result !== true) throw new ArchiveCreateException($this->path, $destination);

        if ($password !== null && method_exists($zip, "setPassword")) $zip->setPassword($password);

        try {
            if ($this->isDirectory()) {
                $this->addDirectoryToZip($zip, $this->path, basename($this->path));
            } else {
                $zip->addFile($this->path, basename($this->path));

                if ($password !== null && method_exists($zip, "setEncryptionName")) {
                    $zip->setEncryptionName(basename($this->path), ZipArchive::EM_AES_256);
                }
            }

            $zip->close();

            return new static($destination);
        } catch (\Exception $e) {
            $zip->close();

            @unlink($destination);

            throw new ArchiveCreateException($this->path, $destination);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function extract(string|null $destination = null, string|null $password = null): array
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        $destination = $destination ?? $this->dirname() . DIRECTORY_SEPARATOR . $this->filename();

        if (!class_exists("ZipArchive")) throw new ArchiveExtractException($this->path, $destination);

        $zip = new ZipArchive();

        $result = $zip->open($this->path);

        if ($result !== true) throw new ArchiveExtractException($this->path, $destination);

        if ($password !== null && method_exists($zip, "setPassword")) $zip->setPassword($password);

        if (!$zip->extractTo($destination)) {
            $zip->close();

            throw new ArchiveExtractException($this->path, $destination);
        }

        $files = [];
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);

            if ($filename === false) continue;

            $files[] = new static($destination . DIRECTORY_SEPARATOR . $filename);
        }

        $zip->close();

        return $files;
    }

    /**
     * Add directory to ZIP recursively
     *
     * @param \ZipArchive $zip
     * @param string $directory
     * @param string $localPath
     * @return void
     */
    protected function addDirectoryToZip(ZipArchive $zip, string $directory, string $localPath): void
    {
        $zip->addEmptyDir($localPath);

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            $filePath = $file->getPathname();

            $relativePath = $localPath . DIRECTORY_SEPARATOR . substr($filePath, strlen($directory) + 1);

            if ($file->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else {
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    /**
     * Get ZIP error message
     *
     * @param int $code
     * @return string
     */
    protected function getZipErrorMessage(int $code): string
    {
        return match ($code) {
            ZipArchive::ER_OK          => "No error",
            ZipArchive::ER_MULTIDISK   => "Multi-disk archives not supported",
            ZipArchive::ER_RENAME      => "Renaming temporary file failed",
            ZipArchive::ER_CLOSE       => "Closing archive failed",
            ZipArchive::ER_SEEK        => "Seek error",
            ZipArchive::ER_READ        => "Read error",
            ZipArchive::ER_WRITE       => "Write error",
            ZipArchive::ER_CRC         => "CRC error",
            ZipArchive::ER_ZIPCLOSED   => "Archive closed",
            ZipArchive::ER_NOENT       => "No such file",
            ZipArchive::ER_EXISTS      => "File already exists",
            ZipArchive::ER_OPEN        => "Cannot open file",
            ZipArchive::ER_TMPOPEN     => "Failure to create temporary file",
            ZipArchive::ER_ZLIB        => "Zlib error",
            ZipArchive::ER_MEMORY      => "Memory allocation failure",
            ZipArchive::ER_CHANGED     => "Entry changed",
            ZipArchive::ER_COMPNOTSUPP => "Compression method not supported",
            ZipArchive::ER_EOF         => "Unexpected end of file",
            ZipArchive::ER_INVAL       => "Invalid argument",
            ZipArchive::ER_NOZIP       => "Not ZIP archive",
            ZipArchive::ER_INTERNAL    => "Internal error",
            ZipArchive::ER_INCONS      => "Archive inconsistent",
            ZipArchive::ER_REMOVE      => "Cannot remove file",
            ZipArchive::ER_DELETED     => "Entry deleted",

            default => "Unknown error. code: {$code}"
        };
    }

    /*----------------------------------------*
     * Permission
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function changePermissions(int|null $mode = null, string|null $owner = null, string|null $group = null): bool
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        $success = true;

        if ($mode !== null) $success = $success && $this->changeMode($mode);

        if ($owner !== null) $success = $success && $this->changeOwner($owner);

        if ($group !== null) $success = $success && $this->changeGroup($group);

        return $success;
    }

    /**
     * {@inheritDoc}
     */
    public function changeMode(int $mode): bool
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        if ($this->isWindows()) return true;

        $result = @chmod($this->path, $mode);

        if (!$result) throw new PermissionChangeException($this->path, "mode");

        $this->clearCache();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function changeOwner(string $owner): bool
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        if ($this->isWindows()) return true;

        $result = @chown($this->path, $owner);

        if (!$result) throw new PermissionChangeException($this->path, "owner");

        $this->clearCache();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function changeGroup(string $group): bool
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        if ($this->isWindows()) return true;

        $result = @chgrp($this->path, $group);

        if (!$result) throw new PermissionChangeException($this->path, "group");

        $this->clearCache();

        return true;
    }

    /*----------------------------------------*
     * Touch
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function touch(int|null $modificationTime = null, int|null $accessTime = null): bool
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        $result = match (true) {
            $modificationTime === null => @touch($this->path),
            $accessTime       === null => @touch($this->path, $modificationTime),

            default => @touch($this->path, $modificationTime, $accessTime),
        };

        if (!$result) return false;

        $this->clearCache();

        return true;
    }

    /*----------------------------------------*
     * Lock
     *----------------------------------------*/

    /**
     * File lock handle
     *
     * @var resource|null
     */
    protected $lockHandle = null;

    /**
     * {@inheritDoc}
     */
    public function lock(bool $blocking = true): bool
    {
        if (!$this->exists()) throw new NotFoundException($this->path);

        if ($this->lockHandle !== null) return true;

        $this->lockHandle = @fopen($this->path, "r+");

        if ($this->lockHandle === false) {
            $this->lockHandle = null;

            throw new LockException($this->path, "lock");
        }

        $operation = LOCK_EX;

        if (!$blocking) $operation |= LOCK_NB;

        if (flock($this->lockHandle, $operation)) return true;

        fclose($this->lockHandle);

        $this->lockHandle = null;

        if (!$blocking) return false;

        throw new LockException($this->path, "lock");
    }

    /**
     * {@inheritDoc}
     */
    public function unlock(): bool
    {
        if ($this->lockHandle === null) return true;

        if (!flock($this->lockHandle, LOCK_UN)) throw new LockException($this->path, "unlock");

        fclose($this->lockHandle);

        $this->lockHandle = null;

        return true;
    }

    /*----------------------------------------*
     * Transaction
     *----------------------------------------*/

    /**
     * Transaction log for rollback
     *
     * @var array<array<string, string|null>>
     */
    protected array $transactions = [];

    /**
     * Begin transaction
     *
     * @param string $action
     * @param string $source
     * @param string|null $destination
     * @return void
     */
    protected function beginTransaction(string $action, string $source, string|null $destination = null): void
    {
        $this->transactions[] = [
            "action"      => $action,
            "source"      => $source,
            "destination" => $destination
        ];
    }

    /**
     * Commit transaction
     *
     * @return void
     */
    protected function commitTransaction(): void
    {
        $this->transactions = [];
    }

    /**
     * Rollback transaction
     *
     * @return void
     */
    protected function rollbackTransaction(): void
    {
        foreach (array_reverse($this->transactions) as $entry) {
            match ($entry["action"]) {
                "copy" => $this->rollbackCopyTransaction($entry["source"], $entry["destination"]),
                "move" => $this->rollbackMoveTransaction($entry["source"], $entry["destination"]),
            };
        }

        $this->transactions = [];
    }

    /**
     * Rollback copy transaction
     *
     * @param string $source
     * @param string|null $destination
     * @return void
     */
    protected function rollbackCopyTransaction(string $source, string $destination): void
    {
        if (is_null($destination) || !file_exists($destination)) return;

        @unlink($destination);
    }

    /**
     * Rollback move transaction
     *
     * @param string $source
     * @param string|null $destination
     * @return void
     */
    protected function rollbackMoveTransaction(string $source, string $destination): void
    {
        if (is_null($destination) || !file_exists($destination) || file_exists($source)) return;

        @rename($destination, $source);
    }
}
