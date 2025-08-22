<?php

namespace Spark\Foundation\File;

use Spark\File\Pathinfo;

/**
 * File Reader
 *
 * @package Spark\Foundation\File
 */
abstract class Reader extends Pathinfo
{
    /*----------------------------------------*
     * Read
     *----------------------------------------*/

    /**
     * read file
     *
     * @return mixed
     */
    abstract public function read(): mixed;

    /**
     * read raw file content
     *
     * @return string|null
     */
    protected function readRaw(): string|null
    {
        if (!$this->validate()) return null;

        $data = file_get_contents($this->path());

        return is_string($data) ? $data : null;
    }

    /**
     * read file with callback using stream
     *
     * @param callable $callback
     * @return mixed
     */
    protected function readWithStream(callable $callback): mixed
    {
        $stream = $this->openStream();

        if ($stream === null) return null;

        try {
            $result = $callback($stream);
        } finally {
            fclose($stream);
        }

        return $result;
    }

    /*----------------------------------------*
     * Resource
     *----------------------------------------*/

    /**
     * get file stream
     *
     * @param string $mode
     * @return resource|null
     */
    protected function openStream(string $mode = "r")
    {
        if (!$this->validate()) return null;

        return fopen($this->path(), $mode);
    }

    /**
     * get file object
     *
     * @param string $mode
     * @return \SplFileObject|null
     */
    protected function openFileObject(string $mode = "r"): \SplFileObject|null
    {
        if (!$this->validate()) return null;

        try {
            return new \SplFileObject($this->path(), $mode);
        } catch (\Exception $e) {
            return null;
        }
    }

    /*----------------------------------------*
     * Validate
     *----------------------------------------*/

    /**
     * validate file
     *
     * @return bool
     */
    public function validate(): bool
    {
        if (!$this->isExists()) return false;

        if (!$this->isReadable()) return false;

        if (!$this->isSupported()) return false;

        return $this->validateFormat();
    }

    /**
     * whether file extension is supported
     *
     * @return bool
     */
    public function isSupported(): bool
    {
        return in_array($this->extension(), $this->supportedExtensions());
    }

    /**
     * get supported file extensions
     *
     * @return array
     */
    abstract public function supportedExtensions(): array;

    /**
     * validate file format
     *
     * @return bool
     */
    abstract protected function validateFormat(): bool;
}
