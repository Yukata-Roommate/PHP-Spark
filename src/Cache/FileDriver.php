<?php

declare(strict_types=1);

namespace Spark\Cache;

use Spark\Contracts\Cache\FileDriver as FileDriverContract;
use Spark\Foundation\Cache\Driver;

use Spark\Exceptions\Cache\CacheException;
use Spark\Exceptions\Cache\FileReadException;
use Spark\Exceptions\Cache\FileWriteException;
use Spark\Exceptions\Cache\FileDeleteException;
use Spark\Exceptions\Cache\DirectoryCreateException;
use Spark\Exceptions\Cache\DirectoryDeleteException;
use Spark\Exceptions\Cache\DataCorruptedException;

/**
 * File Cache Driver
 *
 * @package Spark\Cache
 */
class FileDriver extends Driver implements FileDriverContract
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     *
     * @param string $directory
     * @throws \Spark\Exceptions\Cache\DirectoryCreateException
     */
    public function __construct(string $directory)
    {
        $this->setDirectory($directory);
    }

    /*----------------------------------------*
     * Storage
     *----------------------------------------*/

    /**
     * Cache directory
     *
     * @var string
     */
    protected string $directory;

    /**
     * Cache file extension
     *
     * @var string
     */
    protected string $extension = ".cache.php";

    /**
     * {@inheritDoc}
     */
    public function setDirectory(string $directory): static
    {
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR);

        if (is_dir($this->directory)) return $this;

        if (mkdir($this->directory, 0755, true)) return $this;

        throw new DirectoryCreateException($this->directory);
    }

    /**
     * {@inheritDoc}
     */
    public function directory(): string
    {
        return $this->directory;
    }

    /**
     * Get cache file path
     *
     * @param string $key
     * @return string
     * @throws \Spark\Exceptions\Cache\DirectoryCreateException
     */
    protected function filePath(string $key): string
    {
        $hash = md5($key);

        $subDirectory = substr($hash, 0, 2);

        $directory = $this->directory . DIRECTORY_SEPARATOR . $subDirectory;

        if (!is_dir($directory) && !mkdir($directory, 0755, true)) throw new DirectoryCreateException($directory);

        $fileName = $hash . $this->extension;

        return $directory . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * Get files iterator
     *
     * @param int $mode
     * @return \Generator<\SplFileInfo>
     */
    protected function files(int $mode): \Generator
    {
        if (!is_dir($this->directory)) return;

        try {
            $directoryIterator = new \RecursiveDirectoryIterator(
                $this->directory,
                \RecursiveDirectoryIterator::SKIP_DOTS
            );

            $files = new \RecursiveIteratorIterator($directoryIterator, $mode);

            foreach ($files as $file) {
                if ($file->isDir()) {
                    yield $file;
                } else if ($file->isFile() && str_ends_with($file->getFilename(), $this->extension)) {
                    yield $file;
                }
            }
        } catch (\UnexpectedValueException) {
            return;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function diskUsage(): int
    {
        $size = 0;

        foreach ($this->files(\RecursiveIteratorIterator::LEAVES_ONLY) as $fileinfo) {
            if (!$fileinfo->isFile()) continue;

            $size += $fileinfo->getSize();
        }

        return $size;
    }

    /*----------------------------------------*
     * Load
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    protected function has(string $key): bool
    {
        try {
            $filePath = $this->filePath($key);

            return file_exists($filePath) && is_readable($filePath);
        } catch (CacheException) {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     * @throws \Spark\Exceptions\Cache\FileReadException
     * @throws \Spark\Exceptions\Cache\DataCorruptedException
     */
    protected function read(string $key): mixed
    {
        $filePath = $this->filePath($key);

        $data = @file_get_contents($filePath);

        if ($data === false) throw new FileReadException($filePath);

        $unserialized = @unserialize($data);

        if ($unserialized === false && $data !== serialize(false)) throw new DataCorruptedException($key, "Failed to unserialize data");

        return $unserialized;
    }

    /*----------------------------------------*
     * Save
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     * @throws \Spark\Exceptions\Cache\FileWriteException
     * @throws \Spark\Exceptions\Cache\DirectoryCreateException
     */
    protected function write(string $key, array $data): void
    {
        $filePath = $this->filePath($key);

        $data["_key"] = $key;

        $serialized = serialize($data);

        if (@file_put_contents($filePath, $serialized, LOCK_EX) === false) throw new FileWriteException($filePath);
    }

    /*----------------------------------------*
     * Delete
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     * @throws \Spark\Exceptions\Cache\FileDeleteException
     */
    protected function remove(string $key): void
    {
        $filePath = $this->filePath($key);

        if (!file_exists($filePath)) return;

        if (!@unlink($filePath)) throw new FileDeleteException($filePath);
    }

    /**
     * {@inheritDoc}
     * @throws \Spark\Exceptions\Cache\DirectoryDeleteException
     * @throws \Spark\Exceptions\Cache\FileDeleteException
     */
    protected function flush(): void
    {
        foreach ($this->files(\RecursiveIteratorIterator::CHILD_FIRST) as $fileinfo) {
            $path = $fileinfo->getRealPath();

            if ($fileinfo->isDir()) {
                if (!@rmdir($path)) throw new DirectoryDeleteException($path);
            } elseif ($fileinfo->isFile()) {
                if (!@unlink($path)) throw new FileDeleteException($path);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function clean(): int
    {
        $count = 0;

        foreach ($this->files(\RecursiveIteratorIterator::LEAVES_ONLY) as $fileinfo) {
            if (!$fileinfo->isFile()) continue;

            try {
                $data = @file_get_contents($fileinfo->getRealPath());

                if ($data === false) continue;

                $unserialized = @unserialize($data);

                if ($unserialized === false) {
                    @unlink($fileinfo->getRealPath());

                    $count++;

                    continue;
                }

                $validated = $this->ensureDataStructure($unserialized, "clean_check");

                if (!$this->isExpired($validated)) continue;

                @unlink($fileinfo->getRealPath());

                $count++;
            } catch (CacheException) {
                @unlink($fileinfo->getRealPath());

                $count++;
            }
        }

        return $count;
    }

    /*----------------------------------------*
     * Count
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        $count = 0;

        foreach ($this->files(\RecursiveIteratorIterator::LEAVES_ONLY) as $fileinfo) {
            if (!$fileinfo->isFile()) continue;

            $count++;
        }

        return $count;
    }
}
