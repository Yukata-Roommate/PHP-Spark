<?php

namespace Spark\Cache;

use Spark\Contracts\Cache\FileDriver as FileDriverContract;
use Spark\Foundation\Cache\Driver;

use Spark\Exceptions\Cache\CacheException;
use Spark\Exceptions\Cache\CacheStorageException;
use Spark\Exceptions\Cache\CacheDataCorruptedException;

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
     * Set cache directory
     *
     * @param string $directory
     * @return static
     */
    public function setDirectory(string $directory): static
    {
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR);

        if (is_dir($this->directory)) return $this;

        if (mkdir($this->directory, 0755, true)) return $this;

        throw new CacheStorageException("create_directory", "Failed to create cache directory: {$this->directory}");
    }

    /**
     * Get cache file path
     *
     * @param string $key
     * @return string
     */
    protected function filePath(string $key): string
    {
        $hash = md5($key);

        $subDirectory = substr($hash, 0, 2);

        $directory = $this->directory . DIRECTORY_SEPARATOR . $subDirectory;

        if (!is_dir($directory) && !mkdir($directory, 0755, true)) throw new CacheStorageException("create_subdirectory", "Failed to create cache subdirectory: $directory");

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
        } catch (\UnexpectedValueException $e) {
            return;
        }
    }

    /**
     * Get disk usage in bytes
     *
     * @return int
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

    /**
     * Get cache files count
     *
     * @return int
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

    /*----------------------------------------*
     * Load
     *----------------------------------------*/

    /**
     * Check if key exists in storage
     *
     * @param string $key
     * @return bool
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
     * Read raw data from storage
     *
     * @param string $key
     * @return mixed
     */
    protected function read(string $key): mixed
    {
        $filePath = $this->filePath($key);

        $data = @file_get_contents($filePath);

        if ($data === false) throw new CacheStorageException("read_file", "Failed to read cache file: $filePath");

        $unserialized = @unserialize($data);

        if ($unserialized === false && $data !== serialize(false)) throw new CacheDataCorruptedException("Failed to unserialize cache data for key: $key");

        return $unserialized;
    }

    /*----------------------------------------*
     * Save
     *----------------------------------------*/

    /**
     * Write data to storage
     *
     * @param string $key
     * @param array $data
     * @return void
     */
    protected function write(string $key, array $data): void
    {
        $filePath = $this->filePath($key);

        $data["_key"] = $key;

        $serialized = serialize($data);

        if (@file_put_contents($filePath, $serialized, LOCK_EX) === false) throw new CacheStorageException("write_file", "Failed to write cache file: $filePath");
    }

    /*----------------------------------------*
     * Delete
     *----------------------------------------*/

    /**
     * Remove cache value from storage
     *
     * @param string $key
     * @return void
     */
    protected function remove(string $key): void
    {
        $filePath = $this->filePath($key);

        if (!file_exists($filePath)) return;

        if (!@unlink($filePath)) throw new CacheStorageException("delete_file", "Failed to delete cache file: $filePath");
    }

    /**
     * Flush all cache values from storage
     *
     * @return void
     */
    protected function flush(): void
    {
        foreach ($this->files(\RecursiveIteratorIterator::CHILD_FIRST) as $fileinfo) {
            $path = $fileinfo->getRealPath();

            if ($fileinfo->isDir()) {
                if (!@rmdir($path)) throw new CacheStorageException("remove_directory", "Failed to remove directory: $path");
            } elseif ($fileinfo->isFile()) {
                if (!@unlink($path)) throw new CacheStorageException("remove_file", "Failed to remove file: $path");
            }
        }
    }

    /**
     * Clean expired cache values
     *
     * @return int
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

                $validated = $this->ensureDataStructure($unserialized);

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
}
