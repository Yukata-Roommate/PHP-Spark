<?php

declare(strict_types=1);

namespace Spark\Console\Commands;

use Spark\Foundation\Console\Command;

/**
 * Tree Command
 *
 * @package Spark\Console\Commands
 */
class TreeCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected string $signature = "tree";

    /**
     * {@inheritDoc}
     */
    protected string $description = "Show directory structure in tree format";

    /*----------------------------------------*
     * Run
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    protected function execute(): void
    {
        $path = $this->string(0) ?: getcwd();

        $realpath = realpath($path);

        if ($realpath === false || !is_dir($realpath)) throw new \InvalidArgumentException("Invalid directory path: $path");

        $this->visitedPaths      = [];
        $this->gitignorePatterns = [];

        $this->line(basename($realpath));

        $this->writeRecursively($realpath, "", 0);

        $this->newLine();

        $this->line($this->formatStatistics());
    }

    /**
     * Write recursively
     *
     * @param string $path
     * @param string $prefix
     * @param int $depth
     * @return void
     */
    protected function writeRecursively(string $path, string $prefix, int $depth): void
    {
        if ($this->maxDepth !== null && $depth >= $this->maxDepth) return;

        if ($this->isPathVisited($path)) return;

        $this->loadGitignore($path);

        try {
            $items = $this->getDirectoryItems($path);

            if (empty($items)) return;

            $total = count($items);

            foreach ($items as $index => $item) {
                $this->writeItem($item, $prefix, $depth, ($index === $total - 1));
            }
        } finally {
            $this->unsetVisitedPath($path);
        }
    }

    /**
     * Get directory items
     *
     * @param string $path
     * @return array<array<string, mixed>>
     */
    protected function getDirectoryItems(string $path): array
    {
        if (!is_dir($path)) throw new \InvalidArgumentException("Path is not directory: $path");

        if (!is_readable($path)) return [];

        $handle = opendir($path);

        if ($handle === false) throw new \RuntimeException("Failed to open directory: $path");

        $items = [];

        while (($item = readdir($handle)) !== false) {
            if ($item === "." || $item === "..") continue;

            $itemPath = $path . DIRECTORY_SEPARATOR . $item;

            if ($this->shouldSkip($item, $itemPath)) continue;

            $stat = @lstat($itemPath);

            if ($stat === false) continue;

            $items[] = [
                "name"   => $item,
                "path"   => $itemPath,
                "size"   => $stat["size"] ?? 0,
                "mtime"  => $stat["mtime"] ?? 0,
                "isDir"  => is_dir($itemPath),
                "isFile" => is_file($itemPath),
                "isLink" => is_link($itemPath),
            ];
        }

        closedir($handle);

        usort($items, fn($a, $b) => strcasecmp($a["name"], $b["name"]));

        return $items;
    }

    /**
     * Whether to skip item based on filters
     *
     * @param string $item
     * @param string $itemPath
     * @return bool
     */
    protected function shouldSkip(string $item, string $itemPath): bool
    {
        if ($item === ".git") return true;

        if (!$this->showHiddens && str_starts_with($item, ".")) return true;

        if ($this->matchesExcludePattern($item)) return true;

        if ($this->considerGitignores && $this->isIgnoredByGitignore($itemPath)) return true;

        return false;
    }

    /**
     * Whether item matches exclude patterns
     *
     * @param string $item
     * @return bool
     */
    protected function matchesExcludePattern(string $item): bool
    {
        foreach ($this->excludePatterns as $pattern) {
            if (fnmatch($pattern, $item)) return true;
        }

        return false;
    }

    /**
     * Write item to output
     *
     * @param array $item
     * @param string $prefix
     * @param int $depth
     * @param bool $isLast
     * @return void
     */
    protected function writeItem(array $item, string $prefix, int $depth, bool $isLast): void
    {
        $connector = $isLast ? "└── " : "├── ";

        $name = $item["name"];

        $info = $this->buildInfoString($item);

        if ($info) $name .= " " . $info;

        $this->line($prefix . $connector . $name);

        if ($item["isDir"]) {
            $this->incrementDirectoryCount();

            $this->writeRecursively(
                $item["path"],
                $prefix . ($isLast ? "    " : "│   "),
                $depth + 1
            );
        } else {
            $this->incrementFileCount();

            if ($item["size"] > 0) $this->addTotalSize($item["size"]);
        }
    }

    /**
     * Build file info string
     *
     * @param array $itemData
     * @return string
     */
    protected function buildInfoString(array $itemData): string
    {
        $parts = [];

        if ($this->showFileSize && $itemData["size"] > 0) $parts[] = $this->formatSize($itemData["size"]);

        if ($this->showFileModifiedTime && $itemData["mtime"] > 0) $parts[] = date("Y-m-d H:i:s", $itemData["mtime"]);

        return empty($parts) ? "" : "[" . implode(", ", $parts) . "]";
    }

    /*----------------------------------------*
     * Visited Path
     *----------------------------------------*/

    /**
     * Visited paths
     *
     * @var array
     */
    protected array $visitedPaths = [];

    /**
     * Whether path is visited
     *
     * @param string $path
     * @return bool
     */
    protected function isPathVisited(string $path): bool
    {
        $realPath = realpath($path);

        if ($realPath === false) throw new \RuntimeException("Failed to resolve real path for directory: {$path}");

        if (isset($this->visitedPaths[$realPath])) return true;

        $this->visitedPaths[$realPath] = true;

        return false;
    }

    /**
     * Unset visited path
     *
     * @param string $path
     * @return void
     */
    protected function unsetVisitedPath(string $path): void
    {
        $realPath = realpath($path);

        if ($realPath === false) throw new \RuntimeException("Failed to resolve real path for directory: {$path}");

        unset($this->visitedPaths[$realPath]);
    }

    /*----------------------------------------*
     * Gitignore
     *----------------------------------------*/

    /**
     * Patterns from .gitignore
     *
     * @var array<string, array<string>>
     */
    protected array $gitignorePatterns = [];

    /**
     * Load .gitignore patterns
     *
     * @param string $path
     * @return void
     */
    protected function loadGitignore(string $path): void
    {
        if (!$this->considerGitignores) return;

        $path = rtrim($path, DIRECTORY_SEPARATOR);

        $gitignorePath = $path . DIRECTORY_SEPARATOR . ".gitignore";

        if (!file_exists($gitignorePath) || !is_readable($gitignorePath)) return;

        $content = file_get_contents($gitignorePath);

        if ($content === false) return;

        $patterns = explode(PHP_EOL, $content);

        foreach ($patterns as $pattern) {
            $pattern = trim($pattern);

            if (empty($pattern) || str_starts_with($pattern, "#")) continue;

            $this->gitignorePatterns[] = [
                "pattern" => $pattern,
                "path"    => $path,
            ];
        }
    }

    /**
     * Whether item is ignored by .gitignore
     *
     * @param string $itemPath
     * @return bool
     */
    protected function isIgnoredByGitignore(string $itemPath): bool
    {
        $ignored = false;

        foreach ($this->gitignorePatterns as $entry) {
            if (!str_starts_with($itemPath, $entry["path"])) continue;

            $relativePath = substr($itemPath, strlen($entry["path"]) + 1);

            if (str_starts_with($entry["pattern"], "!")) {
                $negPattern = substr($entry["pattern"], 1);

                if ($this->matchesGitignorePattern($relativePath, $negPattern)) $ignored = false;

                continue;
            }

            if ($this->matchesGitignorePattern($relativePath, $entry["pattern"])) $ignored = true;
        }

        return $ignored;
    }

    /**
     * Whether relative path matches gitignore pattern
     *
     * @param string $relativePath
     * @param string $pattern
     * @return bool
     */
    protected function matchesGitignorePattern(string $relativePath, string $pattern): bool
    {
        $pattern = rtrim($pattern, "/");

        $isRootPattern = str_starts_with($pattern, "/");
        if ($isRootPattern) {
            $pattern = ltrim($pattern, "/");

            if ($relativePath === $pattern) return true;

            if (str_starts_with($relativePath, $pattern . DIRECTORY_SEPARATOR)) return true;

            return false;
        }

        if ($relativePath === $pattern) return true;

        if (str_contains($pattern, "*") || str_contains($pattern, "?")) return fnmatch($pattern, $relativePath);

        $pathParts = explode(DIRECTORY_SEPARATOR, $relativePath);

        return in_array($pattern, $pathParts);
    }

    /*----------------------------------------*
     * Statistics
     *----------------------------------------*/

    /**
     * Directory count
     *
     * @var int
     */
    protected int $directoryCount = 0;

    /**
     * File count
     *
     * @var int
     */
    protected int $fileCount = 0;

    /**
     * Total size
     *
     * @var int
     */
    protected int $totalSize = 0;

    /**
     * Format statistics
     *
     * @return string
     */
    protected function formatStatistics(): string
    {
        return sprintf(
            "%d directories, %d files, %s total",
            $this->directoryCount,
            $this->fileCount,
            $this->formatSize($this->totalSize)
        );
    }

    /**
     * Increment directory count
     *
     * @return void
     */
    protected function incrementDirectoryCount(): void
    {
        $this->directoryCount++;
    }

    /**
     * Increment file count
     *
     * @return void
     */
    protected function incrementFileCount(): void
    {
        $this->fileCount++;
    }

    /**
     * Add total size
     *
     * @param int $size
     * @return void
     */
    protected function addTotalSize(int $size): void
    {
        $this->totalSize += $size;
    }

    /*----------------------------------------*
     * Config
     *----------------------------------------*/

    /**
     * Max depth limit
     *
     * @var int|null
     */
    protected int|null $maxDepth = null;

    /**
     * Whether show hidden files
     *
     * @var bool
     */
    protected bool $showHiddens = false;

    /**
     * Whether consider .gitignore files pattern
     *
     * @var bool
     */
    protected bool $considerGitignores = false;

    /**
     * Exclude patterns
     *
     * @var array
     */
    protected array $excludePatterns = [];

    /**
     * Whether show file size
     *
     * @var bool
     */
    protected bool $showFileSize = true;

    /**
     * Whether show file modified time
     *
     * @var bool
     */
    protected bool $showFileModifiedTime = true;

    /*----------------------------------------*
     * Readable Size
     *----------------------------------------*/

    /**
     * Format size to human-readable string
     *
     * @param int $size
     * @return string
     */
    protected function formatSize(int $size): string
    {
        if ($size < 1024) return $size . " B";

        $units = ["B", "KB", "MB", "GB", "TB"];
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return sprintf("%.2f %s", $size, $units[$unitIndex]);
    }
}
