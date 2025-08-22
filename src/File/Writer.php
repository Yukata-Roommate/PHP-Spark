<?php

namespace Spark\File;

use Spark\File\Operator;

/**
 * File Writer
 *
 * @package Spark\File
 */
class Writer extends Operator
{
    /*----------------------------------------*
     * Write
     *----------------------------------------*/

    /**
     * write file
     *
     * @param int|null $mode
     * @param string|null $user
     * @param string|null $group
     * @return bool
     */
    public function write(int|null $mode = null, string|null $user = null, string|null $group = null): bool
    {
        $result = $this->createIfNotExists($mode, $user, $group);

        if (!$result) return false;

        $data = $this->getData();

        return $this->writeFile($data);
    }

    /**
     * write file as is
     *
     * @param mixed $data
     * @param int|null $mode
     * @param string|null $user
     * @param string|null $group
     * @return bool
     */
    public function writeAsIs(mixed $data, int|null $mode = null, string|null $user = null, string|null $group = null): bool
    {
        $result = $this->createIfNotExists($mode, $user, $group);

        if (!$result) return false;

        return $this->writeFile($data);
    }

    /**
     * create file if not exists
     *
     * @param int|null $mode
     * @param string|null $user
     * @param string|null $group
     * @return bool
     */
    protected function createIfNotExists(int|null $mode = null, string|null $user = null, string|null $group = null): bool
    {
        if ($this->isExists()) return true;

        $static = $this->create($mode, $user, $group);

        return $static !== null;
    }

    /**
     * get data to write
     *
     * @return mixed
     */
    protected function getData(): mixed
    {
        return $this->contents();
    }

    /**
     * execute writing file
     *
     * @param mixed $data
     * @return bool
     */
    protected function writeFile(mixed $data): bool
    {
        $result = file_put_contents(
            $this->path(),
            $data,
            $this->flag(),
        );

        return $result !== false;
    }

    /*----------------------------------------*
     * Flag
     *----------------------------------------*/

    /**
     * whether to use FILE_APPEND flag
     *
     * @var bool
     */
    protected bool $useFileAppend = false;

    /**
     * whether to use LOCK_EX flag
     *
     * @var bool
     */
    protected bool $useLockEx = false;

    /**
     * get flag
     *
     * @return int
     */
    protected function flag(): int
    {
        return match (true) {
            $this->useFileAppend && $this->useLockEx => FILE_APPEND | LOCK_EX,
            $this->useFileAppend                     => FILE_APPEND,
            $this->useLockEx                         => LOCK_EX,
            default                                  => 0,
        };
    }

    /**
     * whether to use FILE_APPEND flag
     *
     * @return bool
     */
    public function isUseFileAppend(): bool
    {
        return $this->useFileAppend;
    }

    /**
     * use FILE_APPEND flag
     *
     * @return static
     */
    public function useFileAppend(): static
    {
        $this->useFileAppend = true;

        return $this;
    }

    /**
     * not use FILE_APPEND flag
     *
     * @return static
     */
    public function notUseFileAppend(): static
    {
        $this->useFileAppend = false;

        return $this;
    }

    /**
     * whether to use LOCK_EX flag
     *
     * @return bool
     */
    public function isUseLockEx(): bool
    {
        return $this->useLockEx;
    }

    /**
     * use LOCK_EX flag
     *
     * @return static
     */
    public function useLockEx(): static
    {
        $this->useLockEx = true;

        return $this;
    }

    /**
     * not use LOCK_EX flag
     *
     * @return static
     */
    public function notUseLockEx(): static
    {
        $this->useLockEx = false;

        return $this;
    }

    /*----------------------------------------*
     * Contents
     *----------------------------------------*/

    /**
     * contents to write
     *
     * @var mixed
     */
    protected mixed $contents = null;

    /**
     * get contents to write
     *
     * @return mixed
     */
    public function contents(): mixed
    {
        return $this->contents;
    }

    /**
     * set contents to write
     *
     * @param mixed $contents
     * @return static
     */
    public function setContents(mixed $contents): static
    {
        $this->contents = $contents;

        return $this;
    }
}
