<?php

namespace Spark\File;

use Spark\File\Pathinfo;

/**
 * File Operator
 *
 * @package Spark\File
 */
class Operator extends Pathinfo
{
    /*----------------------------------------*
     * Create
     *----------------------------------------*/

    /**
     * create file
     *
     * @param int|null $time
     * @param int|null $atime
     * @return static|null
     */
    public function create(int|null $time = null, int|null $atime = null): static|null
    {
        if ($this->isExists()) return null;

        if (!$this->isDirExists()) $this->createDir();

        $touch = match (true) {
            is_null($time)  => touch($this->path()),
            is_null($atime) => touch($this->path(), $time),

            default => touch($this->path(), $time, $atime),
        };

        if (!$touch) return null;

        return $this;
    }

    /**
     * create directory
     *
     * @return bool
     */
    protected function createDir(): bool
    {
        if ($this->isDirExists()) return false;

        return mkdir($this->dirname(), 0755, true);
    }

    /**
     * create file if not exists
     *
     * @param int|null $time
     * @param int|null $atime
     * @return bool
     */
    public function createIfNotExists(int|null $time = null, int|null $atime = null): bool
    {
        if ($this->isExists()) return true;

        $static = $this->create($time, $atime);

        return $static !== null;
    }

    /*----------------------------------------*
     * Remove
     *----------------------------------------*/

    /**
     * remove file
     *
     * @return bool
     */
    public function remove(): bool
    {
        if (!$this->isExists()) return false;

        return unlink($this->path());
    }

    /*----------------------------------------*
     * Copy
     *----------------------------------------*/

    /**
     * copy file
     *
     * @param string $destination
     * @return static|null
     */
    public function copy(string $destination): static|null
    {
        $copy = new static();

        $copy->setPath($destination);

        if (!$copy->isDirExists()) $copy->createDir();

        $result = copy($this->path(), $copy->path());

        return $result ? $copy : null;
    }

    /*----------------------------------------*
     * Move
     *----------------------------------------*/

    /**
     * move file
     *
     * @param string $destination
     * @return static|null
     */
    public function move(string $destination): static|null
    {
        $move = new static();

        $move->setPath($destination);

        if (!$move->isDirExists()) $move->createDir();

        $result = rename($this->path(), $move->path());

        return $result ? $move : null;
    }

    /**
     * move to temp file
     *
     * @param string|null $destination
     * @return static|null
     */
    public function temp(string|null $destination = null): static|null
    {
        $destination = $destination ?? sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid("spark_", true) . "." . $this->extension();

        return $this->move($destination);
    }

    /**
     * move temp to original
     *
     * @param string|null $destination
     * @return static|null
     */
    public function restore(string|null $destination = null): static|null
    {
        $destination = $destination ?? $this->path();

        return $this->move($destination);
    }

    /**
     * move to backup file
     *
     * @param string|null $destination
     * @return static|null
     */
    public function backup(string|null $destination = null): static|null
    {
        $destination = $destination ?? $this->path() . ".bak";

        return $this->move($destination);
    }

    /**
     * move backup to original
     *
     * @param string|null $destination
     * @return static|null
     */
    public function restoreBackup(string|null $destination = null): static|null
    {
        $destination = $destination ?? $this->path();

        return $this->move($destination);
    }

    /*----------------------------------------*
     * Compress
     *----------------------------------------*/

    /**
     * zip file
     *
     * @param string|null $destination
     * @return static|null
     */
    public function zip(string|null $destination = null): static|null
    {
        $zip = new ZipArchive();

        $destination = $destination ?? $this->dirname() . DIRECTORY_SEPARATOR . $this->basename() . ".zip";

        if ($zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) return null;

        $zip->addFile($this->path(), $this->basename());

        $zip->close();

        return new static($destination);
    }

    /**
     * unzip file
     *
     * @param string|null $destination
     * @return static|array<static>|null
     */
    public function unzip(string|null $destination = null): static|array|null
    {
        if (!$this->isExists()) return null;

        $zip = new ZipArchive();

        if ($zip->open($this->path()) !== true) return null;

        $destination = $destination ?? $this->dirname() . DIRECTORY_SEPARATOR . $this->basename();

        if ($zip->extractTo($destination) !== true) return null;

        $zip->close();

        $files = [];

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $files[] = new static($destination . DIRECTORY_SEPARATOR . $zip->getNameIndex($i));
        }

        return $files;
    }

    /*----------------------------------------*
     * Permission
     *----------------------------------------*/

    /**
     * change file permissions
     *
     * @param int|null $mode
     * @param string|null $user
     * @param string|null $group
     * @return bool
     */
    public function chperm(int|null $mode = null, string|null $user = null, string|null $group = null): bool
    {
        if (!is_null($mode) && !$this->chmod($mode)) return false;

        if (!is_null($user) && !$this->chown($user)) return false;

        if (!is_null($group) && !$this->chgrp($group)) return false;

        return true;
    }

    /**
     * change file mode
     *
     * @param int $mode
     * @return bool
     */
    public function chmod(int $mode): bool
    {
        return chmod($this->path(), $mode);
    }

    /**
     * change file owner
     *
     * @param string $user
     * @return bool
     */
    public function chown(string $user): bool
    {
        return chown($this->path(), $user);
    }

    /**
     * change file group
     *
     * @param string $group
     * @return bool
     */
    public function chgrp(string $group): bool
    {
        return chgrp($this->path(), $group);
    }
}
