<?php

declare(strict_types=1);

namespace Spark\File;

use Spark\Contracts\File\Pathinfo as PathinfoContract;

use Spark\Exceptions\File\NotFoundException;

/**
 * File Pathinfo
 *
 * @package Spark\File
 */
class Pathinfo implements PathinfoContract
{
    /*----------------------------------------*
     * Path
     *----------------------------------------*/

    /**
     * File path
     *
     * @var string
     */
    protected string $path = "";

    /**
     * {@inheritDoc}
     */
    public function setPath(string $path): static
    {
        $this->path = $path;

        $this->clearCache();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function issetPath(): bool
    {
        return !empty($this->path);
    }

    /**
     * {@inheritDoc}
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * {@inheritDoc}
     */
    public function realpath(): string|null
    {
        if (empty($this->path)) return null;

        $realpath = @realpath($this->path);

        return $realpath !== false ? $realpath : null;
    }

    /*----------------------------------------*
     * Cache
     *----------------------------------------*/

    /**
     * Cached path info
     *
     * @var array|null
     */
    protected array|null $pathInfo = null;

    /**
     * Cached statistics
     *
     * @var array|false|null
     */
    protected array|false|null $statistics = null;

    /**
     * Clear cached data
     *
     * @return void
     */
    protected function clearCache(): void
    {
        $this->pathInfo   = null;
        $this->statistics = null;

        clearstatcache(true, $this->path);
    }

    /*----------------------------------------*
     * Info
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function pathInfo(): array
    {
        if ($this->pathInfo === null) $this->pathInfo = pathinfo($this->path);

        return $this->pathInfo;
    }

    /**
     * {@inheritDoc}
     */
    public function dirname(): string
    {
        return $this->pathInfo()["dirname"] ?? "";
    }

    /**
     * {@inheritDoc}
     */
    public function basename(): string
    {
        return $this->pathInfo()["basename"] ?? "";
    }

    /**
     * {@inheritDoc}
     */
    public function extension(): string|null
    {
        $info = $this->pathInfo();

        return isset($info["extension"]) && $info["extension"] !== ""
            ? $info["extension"]
            : null;
    }

    /**
     * {@inheritDoc}
     */
    public function filename(): string
    {
        return $this->pathInfo()["filename"] ?? "";
    }

    /*----------------------------------------*
     * Mime
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function mimetype(): string|null
    {
        if (!$this->exists()) {
            if (!$this->issetPath()) return null;

            throw new NotFoundException($this->path);
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        if ($finfo === false) {
            $mime = @mime_content_type($this->path);

            return $mime !== false ? $mime : null;
        }

        $mime = @finfo_file($finfo, $this->path);

        finfo_close($finfo);

        return $mime !== false ? $mime : null;
    }

    /*----------------------------------------*
     * Last Modified
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function lastModified(): int|null
    {
        if (!$this->exists()) return null;

        $time = @filemtime($this->path);

        return $time !== false ? $time : null;
    }

    /**
     * {@inheritDoc}
     */
    public function lastModifiedDateTime(): \DateTimeInterface|null
    {
        $time = $this->lastModified();

        if ($time === null) return null;

        try {
            return new \DateTimeImmutable("@$time");
        } catch (\Exception) {
            return null;
        }
    }

    /*----------------------------------------*
     * Size
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function size(): int|null
    {
        if (!$this->exists() || $this->isDirectory()) return null;

        $size = @filesize($this->path);

        return $size !== false ? $size : null;
    }

    /**
     * {@inheritDoc}
     */
    public function formattedSize(int $precision = 2): string|null
    {
        $size = $this->size();

        if ($size === null) return null;

        $units         = ["B", "KB", "MB", "GB", "TB", "PB"];
        $unitIndex     = 0;
        $formattedSize = (float)$size;

        while ($formattedSize >= 1024 && $unitIndex < count($units) - 1) {
            $formattedSize /= 1024;

            $unitIndex++;
        }

        return number_format($formattedSize, $precision) . " " . $units[$unitIndex];
    }

    /*----------------------------------------*
     * Permission
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function permissions(): string|null
    {
        if (!$this->exists()) return null;

        $perms = @fileperms($this->path);

        return $perms !== false ? substr(sprintf("%o", $perms), -4) : null;
    }

    /**
     * {@inheritDoc}
     */
    public function owner(): array|null
    {
        if (!$this->exists()) return null;

        $ownerId = @fileowner($this->path);

        if ($ownerId === false) return null;

        if (!$this->isWindows() && function_exists("posix_getpwuid")) {
            $ownerInfo = @posix_getpwuid($ownerId);

            if ($ownerInfo !== false) return ["uid" => $ownerId, "name" => $ownerInfo["name"] ?? "UNKNOWN"];
        }

        return ["uid" => $ownerId, "name" => "UNKNOWN"];
    }

    /**
     * {@inheritDoc}
     */
    public function group(): array|null
    {
        if (!$this->exists()) return null;

        $groupId = @filegroup($this->path);

        if ($groupId === false) return null;

        if (!$this->isWindows() && function_exists("posix_getgrgid")) {
            $groupInfo = @posix_getgrgid($groupId);

            if ($groupInfo !== false) return ["gid" => $groupId, "name" => $groupInfo["name"] ?? "UNKNOWN"];
        }

        return ["gid" => $groupId, "name" => "UNKNOWN"];
    }

    /*----------------------------------------*
     * Check
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function exists(): bool
    {
        return $this->issetPath() && file_exists($this->path);
    }

    /**
     * {@inheritDoc}
     */
    public function parentExists(): bool
    {
        $dirname = $this->dirname();

        return $dirname !== "" && is_dir($dirname);
    }

    /**
     * {@inheritDoc}
     */
    public function isDirectory(): bool
    {
        return $this->issetPath() && is_dir($this->path);
    }

    /**
     * {@inheritDoc}
     */
    public function isFile(): bool
    {
        return $this->issetPath() && is_file($this->path);
    }

    /**
     * {@inheritDoc}
     */
    public function isLink(): bool
    {
        return $this->issetPath() && is_link($this->path);
    }

    /**
     * {@inheritDoc}
     */
    public function isReadable(): bool
    {
        return $this->issetPath() && is_readable($this->path);
    }

    /**
     * {@inheritDoc}
     */
    public function isWritable(): bool
    {
        return $this->issetPath() && is_writable($this->path);
    }

    /**
     * {@inheritDoc}
     */
    public function isExecutable(): bool
    {
        return $this->issetPath() && is_executable($this->path);
    }

    /**
     * {@inheritDoc}
     */
    public function isWindows(): bool
    {
        return DIRECTORY_SEPARATOR === "\\" || PHP_OS_FAMILY === "Windows";
    }

    /*----------------------------------------*
     * Hash
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function hash(string $algorithm = "sha256"): string|null
    {
        if (!$this->isFile() || !$this->isReadable()) return null;

        $hash = @hash_file($algorithm, $this->path);

        return $hash !== false ? $hash : null;
    }

    /*----------------------------------------*
     * Statistics
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function statistics(): array|null
    {
        if (!$this->exists()) return null;

        if ($this->statistics === null) $this->statistics = @stat($this->path);

        return $this->statistics !== false ? $this->statistics : null;
    }
}
