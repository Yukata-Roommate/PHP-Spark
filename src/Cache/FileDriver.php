<?php

namespace Spark\Cache;

use Spark\Contracts\Cache\FileDriver as FileDriverContract;
use Spark\Foundation\Cache\Driver;

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
     * constructor
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
     * cache directory
     *
     * @var string
     */
    protected string $directory;

    /**
     * cache file extension
     *
     * @var string
     */
    protected string $extension = ".cache.php";

    /**
     * set cache directory
     *
     * @param string $directory
     * @return static
     */
    public function setDirectory(string $directory): static
    {
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR);

        if (!is_dir($this->directory)) mkdir($this->directory, 0755, true);

        return $this;
    }

    /**
     * get cache file path
     *
     * @param string $key
     * @return string
     */
    protected function filePath(string $key): string
    {
        $hash = md5($key);

        $subDirectory = substr($hash, 0, 2);

        $directory = $this->directory . DIRECTORY_SEPARATOR . $subDirectory;

        if (!is_dir($directory)) mkdir($directory, 0755, true);

        $fileName  = $hash . $this->extension;

        return $directory . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * get files iterator
     *
     * @param int $mode
     * @return \Generator<\SplFileInfo>
     */
    protected function files(int $mode): \Generator
    {
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
    }

    /**
     * get disk usage
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
     * get cache files count
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
     * whether key exists in storage
     *
     * @param string $key
     * @return bool
     */
    protected function has(string $key): bool
    {
        $filePath = $this->filePath($key);

        return file_exists($filePath) && is_readable($filePath);
    }

    /**
     * read raw data from storage
     *
     * @param string $key
     * @return mixed
     */
    protected function read(string $key): mixed
    {
        if (!$this->has($key)) throw new \RuntimeException("Cache file does not exist. key: $key");

        $filePath = $this->filePath($key);

        $data = file_get_contents($filePath);

        if ($data === false) throw new \RuntimeException("Failed to read cache file: $filePath");

        return unserialize($data);
    }

    /*----------------------------------------*
     * Save
     *----------------------------------------*/

    /**
     * write data to storage
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

        if (file_put_contents($filePath, $serialized)) return;

        throw new \RuntimeException("Failed to write cache file: $filePath");
    }

    /*----------------------------------------*
     * Delete
     *----------------------------------------*/

    /**
     * remove cache value from storage
     *
     * @param string $key
     * @return void
     */
    protected function remove(string $key): void
    {
        $filePath = $this->filePath($key);

        if (!file_exists($filePath)) return;

        if (!unlink($filePath)) throw new \RuntimeException("Failed to delete cache file: {$filePath}");
    }

    /**
     * flush all cache values from storage
     *
     * @return void
     */
    protected function flush(): void
    {
        foreach ($this->files(\RecursiveIteratorIterator::CHILD_FIRST) as $fileinfo) {
            match (true) {
                $fileinfo->isDir()  => rmdir($fileinfo->getRealPath()),
                $fileinfo->isFile() => unlink($fileinfo->getRealPath()),

                default => throw new \RuntimeException("Unknown file type: " . $fileinfo->getRealPath()),
            };
        }
    }

    /**
     * clean expired cache values
     *
     * @return int
     */
    public function clean(): int
    {
        $count = 0;

        foreach ($this->files(\RecursiveIteratorIterator::LEAVES_ONLY) as $fileinfo) {
            if (!$fileinfo->isFile()) continue;

            try {
                $data = file_get_contents($fileinfo->getRealPath());

                if ($data === false) continue;

                $unserialized = unserialize($data);

                $validated = $this->ensureDataStructure($unserialized);

                if (!$this->isExpired($validated)) continue;

                unlink($fileinfo->getRealPath());

                $count++;
            } catch (\Throwable $e) {
                continue;
            }
        }

        return $count;
    }
}
