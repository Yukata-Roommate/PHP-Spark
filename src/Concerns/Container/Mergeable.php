<?php

declare(strict_types=1);

namespace Spark\Concerns\Container;

use Spark\Concerns\Container\Mutable;

/**
 * Mergeable
 *
 * @package Spark\Concerns\Container
 *
 * @method array<string, mixed> getObjectProperties(object $object)
 */
trait Mergeable
{
    use Mutable;

    /**
     * Merge multiple values
     *
     * @param array<string, mixed>|object $values
     * @param bool $overwrite
     * @return static
     */
    public function merge(array|object $values, bool $overwrite = true): static
    {
        $source = &$this->mutableSource();

        $newValues = is_object($values) ? $this->getObjectProperties($values) : $values;

        if ($this->isObjectSource()) {
            foreach ($newValues as $key => $value) {
                if (!$overwrite && isset($source->{$key})) continue;

                $source->{$key} = $value;
            }
        } else {
            if ($overwrite) {
                $source = array_merge($source, $newValues);
            } else {
                $source = array_merge($newValues, $source);
            }
        }

        return $this;
    }

    /**
     * Replace all values
     *
     * @param array<string, mixed>|object $values
     * @return static
     */
    public function replace(array|object $values): static
    {
        $this->clear();

        return $this->merge($values, true);
    }
}
