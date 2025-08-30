<?php

declare(strict_types=1);

namespace Spark\Supports\Superglobals;

use Spark\Foundation\Container\Reference;

/**
 * Files Reference
 *
 * @package Spark\Supports\Superglobals
 */
class Files extends Reference
{
    /*----------------------------------------*
     * Reference
     *----------------------------------------*/

    /**
     * Get reference
     *
     * @return array
     */
    protected function &reference(): array
    {
        return $_FILES;
    }

    /*----------------------------------------*
     * Info
     *----------------------------------------*/

    /**
     * Get file info from reference
     *
     * @param string $info
     * @param string $key
     * @param int $index
     * @return string|int|null
     */
    protected function getFileInfo(string $info, string $key, int $index): string|int|null
    {
        if (!$this->has($key)) return null;

        $fileInfo = $this->get($key)[$info] ?? null;

        return is_array($fileInfo) ? ($fileInfo[$index] ?? null) : $fileInfo ?? null;
    }

    /**
     * Get field file count
     *
     * @param string $key
     * @return int
     */
    public function fileCount(string $key): int
    {
        if (!$this->has($key)) return 0;

        $names = $this->get($key)["name"] ?? null;

        return is_array($names) ? count($names) : 1;
    }

    /**
     * Whether field is multiple
     *
     * @param string $key
     * @return bool
     */
    public function isMultiple(string $key): bool
    {
        return $this->fileCount($key) > 1;
    }

    /**
     * Get file info at index
     *
     * @param string $key
     * @param int $index
     * @return array|null
     */
    public function infoAt(string $key, int $index): array|null
    {
        if (!$this->has($key)) return null;

        return [
            "field"       => $key,
            "index"       => $index,
            "is_multiple" => $this->isMultiple($key),
            "name"        => $this->nameAt($key, $index),
            "type"        => $this->typeAt($key, $index),
            "size"        => $this->sizeAt($key, $index),
            "tmp_name"    => $this->tmpNameAt($key, $index),
            "error"       => $this->errorAt($key, $index),
            "mime_type"   => $this->mimeTypeAt($key, $index),
            "extension"   => $this->extensionAt($key, $index),
            "is_uploaded" => $this->isUploadedAt($key, $index)
        ];
    }

    /**
     * Get file info
     *
     * @param string $key
     * @return array|null
     */
    public function info(string $key): array|null
    {
        return $this->infoAt($key, 0);
    }

    /**
     * Get file name at index
     *
     * @param string $key
     * @param int $index
     * @return string|null
     */
    public function nameAt(string $key, int $index): string|null
    {
        $name = $this->getFileInfo("name", $key, $index);

        return is_null($name) ? null : strval($name);
    }

    /**
     * Get file name
     *
     * @param string $key
     * @return string|null
     */
    public function name(string $key): string|null
    {
        return $this->nameAt($key, 0);
    }

    /**
     * Get file type at index
     *
     * @param string $key
     * @param int $index
     * @return string|null
     */
    public function typeAt(string $key, int $index): string|null
    {
        $type = $this->getFileInfo("type", $key, $index);

        return is_null($type) ? null : strval($type);
    }

    /**
     * Get file type
     *
     * @param string $key
     * @return string|null
     */
    public function type(string $key): string|null
    {
        return $this->typeAt($key, 0);
    }

    /**
     * Get file size at index
     *
     * @param string $key
     * @param int $index
     * @return int|null
     */
    public function sizeAt(string $key, int $index): int|null
    {
        $size = $this->getFileInfo("size", $key, $index);

        return is_null($size) ? null : intval($size);
    }

    /**
     * Get file size
     *
     * @param string $key
     * @return int|null
     */
    public function size(string $key): int|null
    {
        return $this->sizeAt($key, 0);
    }

    /**
     * Get file tmp name at index
     *
     * @param string $key
     * @param int $index
     * @return string|null
     */
    public function tmpNameAt(string $key, int $index): string|null
    {
        $tmpName = $this->getFileInfo("tmp_name", $key, $index);

        return is_null($tmpName) ? null : strval($tmpName);
    }

    /**
     * Get file tmp name
     *
     * @param string $key
     * @return string|null
     */
    public function tmpName(string $key): string|null
    {
        return $this->tmpNameAt($key, 0);
    }

    /**
     * Get file error at index
     *
     * @param string $key
     * @param int $index
     * @return int|null
     */
    public function errorAt(string $key, int $index): int|null
    {
        $error = $this->getFileInfo("error", $key, $index);

        return is_null($error) ? null : intval($error);
    }

    /**
     * Get file error
     *
     * @param string $key
     * @return int|null
     */
    public function error(string $key): int|null
    {
        return $this->errorAt($key, 0);
    }

    /**
     * Get file mime type at index
     *
     * @param string $key
     * @param int $index
     * @return string|null
     */
    public function mimeTypeAt(string $key, int $index): string|null
    {
        $tmpName = $this->tmpNameAt($key, $index);

        if (!$tmpName || !file_exists($tmpName)) return null;

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $tmpName);
        finfo_close($finfo);

        return $mimeType ?: null;
    }

    /**
     * Get file mime type
     *
     * @param string $key
     * @return string|null
     */
    public function mimeType(string $key): string|null
    {
        return $this->mimeTypeAt($key, 0);
    }

    /**
     * Get file extension at index
     *
     * @param string $key
     * @param int $index
     * @return string|null
     */
    public function extensionAt(string $key, int $index): string|null
    {
        $name = $this->nameAt($key, $index);

        if (!$name) return null;

        return pathinfo($name, PATHINFO_EXTENSION) ?: null;
    }

    /**
     * Get file extension
     *
     * @param string $key
     * @return string|null
     */
    public function extension(string $key): string|null
    {
        return $this->extensionAt($key, 0);
    }

    /**
     * Whether file uploaded successfully at index
     *
     * @param string $key
     * @param int $index
     * @return bool
     */
    public function isUploadedAt(string $key, int $index): bool
    {
        return $this->errorAt($key, $index) === UPLOAD_ERR_OK && is_uploaded_file($this->tmpNameAt($key, $index));
    }

    /**
     * Whether file uploaded successfully
     *
     * @param string $key
     * @return bool
     */
    public function isUploaded(string $key): bool
    {
        return $this->isUploadedAt($key, 0);
    }

    /*----------------------------------------*
     * Move
     *----------------------------------------*/

    /**
     * Move uploaded file to destination at index
     *
     * @param string $key
     * @param int $index
     * @param string $destination
     * @return bool
     */
    public function moveAt(string $key, int $index, string $destination): bool
    {
        if (!$this->isUploadedAt($key, $index)) return false;

        return move_uploaded_file($this->tmpNameAt($key, $index), $destination);
    }

    /**
     * Move uploaded file to destination
     *
     * @param string $key
     * @param string $destination
     * @return bool
     */
    public function move(string $key, string $destination): bool
    {
        return $this->moveAt($key, 0, $destination);
    }

    /*----------------------------------------*
     * Validation
     *----------------------------------------*/

    /**
     * Whether file size is less than or equal to size at index
     *
     * @param string $key
     * @param int $index
     * @param int $maxSize
     * @return bool
     */
    public function isWithinSizeAt(string $key, int $index, int $maxSize): bool
    {
        $size = $this->sizeAt($key, $index);

        return !is_null($size) && $size <= $maxSize;
    }

    /**
     * Whether file size is less than or equal to size
     *
     * @param string $key
     * @param int $maxSize
     * @return bool
     */
    public function isWithinSize(string $key, int $maxSize): bool
    {
        return $this->isWithinSizeAt($key, 0, $maxSize);
    }

    /**
     * Whether file type is in allowed types at index
     *
     * @param string $key
     * @param int $index
     * @param array $allowedTypes
     * @return bool
     */
    public function isAllowedTypeAt(string $key, int $index, array $allowedTypes): bool
    {
        $type = $this->typeAt($key, $index);

        return !is_null($type) && in_array($type, $allowedTypes, true);
    }

    /**
     * Whether file type is in allowed types
     *
     * @param string $key
     * @param array $allowedTypes
     * @return bool
     */
    public function isAllowedType(string $key, array $allowedTypes): bool
    {
        return $this->isAllowedTypeAt($key, 0, $allowedTypes);
    }

    /**
     * Whether file extension is in allowed extensions at index
     *
     * @param string $key
     * @param int $index
     * @param array $allowedExtensions
     * @return bool
     */
    public function isAllowedExtensionAt(string $key, int $index, array $allowedExtensions): bool
    {
        $extension = $this->extensionAt($key, $index);

        return !is_null($extension) && in_array($extension, $allowedExtensions, true);
    }

    /**
     * Whether file extension is in allowed extensions
     *
     * @param string $key
     * @param array $allowedExtensions
     * @return bool
     */
    public function isAllowedExtension(string $key, array $allowedExtensions): bool
    {
        return $this->isAllowedExtensionAt($key, 0, $allowedExtensions);
    }

    /**
     * Whether file mime type is in allowed mime types at index
     *
     * @param string $key
     * @param int $index
     * @param array $allowedMimeTypes
     * @return bool
     */
    public function isAllowedMimeTypeAt(string $key, int $index, array $allowedMimeTypes): bool
    {
        $mimeType = $this->mimeTypeAt($key, $index);

        return !is_null($mimeType) && in_array($mimeType, $allowedMimeTypes, true);
    }

    /**
     * Whether file mime type is in allowed mime types
     *
     * @param string $key
     * @param array $allowedMimeTypes
     * @return bool
     */
    public function isAllowedMimeType(string $key, array $allowedMimeTypes): bool
    {
        return $this->isAllowedMimeTypeAt($key, 0, $allowedMimeTypes);
    }

    /*----------------------------------------*
     * Flatten
     *----------------------------------------*/

    /**
     * Get flattened files array
     *
     * @return array
     */
    public function flatten(): array
    {
        $flattened = [];

        foreach ($this->keys() as $fieldName) {
            $count = $this->fileCount($fieldName);

            for ($i = 0; $i < $count; $i++) {
                $flattened[] = $this->infoAt($fieldName, $i);
            }
        }

        return $flattened;
    }

    /**
     * Get filtered flattened files array
     *
     * @param callable|array $filter
     * @return array
     */
    public function flattenFiltered(callable|array $filter): array
    {
        if (is_callable($filter)) return array_filter($this->flatten(), $filter);

        return array_filter($this->flatten(), function ($file) use ($filter) {
            return array_reduce(array_keys($filter), function ($carry, $key) use ($file, $filter) {
                return $carry && isset($file[$key]) && $file[$key] === $filter[$key];
            }, true);
        });
    }

    /**
     * Get successful flattened files array
     *
     * @return array
     */
    public function flattenSuccessful(): array
    {
        return $this->flattenFiltered(["is_uploaded" => true]);
    }

    /**
     * Get failed flattened files array
     *
     * @return array
     */
    public function flattenFailed(): array
    {
        return $this->flattenFiltered(["is_uploaded" => false]);
    }
}
