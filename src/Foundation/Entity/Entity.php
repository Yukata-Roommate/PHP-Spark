<?php

namespace Spark\Foundation\Entity;

use Spark\Foundation\Entity\DataAccessor;

/**
 * Entity
 *
 * @package Spark\Foundation\Entity
 */
abstract class Entity extends DataAccessor
{
    /*----------------------------------------*
     * Data
     *----------------------------------------*/

    /**
     * data
     *
     * @var array|object|null
     */
    protected array|object|null $_data = null;

    /**
     * constructor
     *
     * @param array|object|null $data
     */
    public function __construct(array|object|null $data = null)
    {
        $this->setData($data);
    }

    /**
     * get data
     *
     * @return array|object|null
     */
    public function data(): array|object|null
    {
        return $this->_data;
    }

    /**
     * set data
     *
     * @param array|object|null $data
     * @return static
     */
    public function setData(array|object|null $data): static
    {
        $this->_data = $data;

        return $this;
    }

    /**
     * flush data
     *
     * @return static
     */
    public function flush(): static
    {
        return $this->setData(null);
    }

    /*----------------------------------------*
     * Check
     *----------------------------------------*/

    /**
     * isset value
     *
     * @param string $name
     * @return bool
     */
    public function isset(string $name): bool
    {
        if (is_array($this->_data) && isset($this->_data[$name])) return true;

        if (is_object($this->_data) && isset($this->_data->{$name})) return true;

        return false;
    }

    /**
     * has value
     *
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return $this->isset($name);
    }

    /*----------------------------------------*
     * Get
     *----------------------------------------*/

    /**
     * get value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get(string $name, mixed $default = null): mixed
    {
        return match (true) {
            !$this->isset($name)    => $default,
            is_array($this->_data)  => $this->_data[$name],
            is_object($this->_data) => $this->_data->{$name},
            default => $default,
        };
    }

    /*----------------------------------------*
     * Set
     *----------------------------------------*/

    /**
     * set value
     *
     * @param string $name
     * @param mixed $value
     * @return static
     */
    public function set(string $name, mixed $value): static
    {
        if (is_null($this->_data)) $this->setData([]);

        if (is_array($this->_data)) {
            $this->_data[$name] = $value;
        } elseif (is_object($this->_data)) {
            $this->_data->{$name} = $value;
        }

        return $this;
    }

    /**
     * add value
     *
     * @param string $name
     * @param mixed $value
     * @return static
     */
    public function add(string $name, mixed $value): static
    {
        return $this->set($name, $value);
    }

    /*----------------------------------------*
     * Unset
     *----------------------------------------*/

    /**
     * unset value
     *
     * @param string $name
     * @return static
     */
    public function unset(string $name): static
    {
        if (!$this->isset($name)) return $this;

        if (is_array($this->_data)) {
            unset($this->_data[$name]);
        } elseif (is_object($this->_data)) {
            unset($this->_data->{$name});
        }

        return $this;
    }

    /**
     * remove value
     *
     * @param string $name
     * @return static
     */
    public function remove(string $name): static
    {
        return $this->unset($name);
    }

    /*----------------------------------------*
     * Properties
     *----------------------------------------*/

    /**
     * get public properties
     *
     * @param object|null $object
     * @return array<string, mixed>
     */
    protected function getPublicProperties(object|null $object): array
    {
        if (is_null($object)) return [];

        $reflector          = new \ReflectionObject($object);
        $reflectorClassName = $reflector->getName();
        $reflectProperties  = $reflector->getProperties(\ReflectionProperty::IS_PUBLIC);

        $properties = [];

        foreach ($reflectProperties as $property) {
            if ($property->class !== $reflectorClassName) continue;
            if ($property->isInitialized($object) === false) continue;
            if ($property->isStatic()) continue;

            $name = $property->getName();

            $properties[$name] = $property->getValue($object);
        }

        return $properties;
    }

    /**
     * get all properties
     *
     * @return array<string, mixed>
     */
    public function properties(): array
    {
        return $this->getPublicProperties($this);
    }

    /*----------------------------------------*
     * All
     *----------------------------------------*/

    /**
     * get all
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        $data = match (true) {
            is_array($this->_data)  => $this->_data,
            is_object($this->_data) => $this->getPublicProperties($this->_data),

            default => [],
        };

        return array_merge($data, $this->properties());
    }

    /**
     * to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->all();
    }

    /*----------------------------------------*
     * Filter
     *----------------------------------------*/

    /**
     * get only properties with keys
     *
     * @param string|array<string> ...$keys
     * @return array<string, mixed>
     */
    public function only(string|array ...$keys): array
    {
        $keys = $this->mergeKeys(...$keys);

        $all = $this->all();

        return array_filter($all, fn($key) => in_array($key, $keys), ARRAY_FILTER_USE_KEY);
    }

    /**
     * get except properties with keys
     *
     * @param string|array<string> ...$keys
     * @return array<string, mixed>
     */
    public function except(string|array ...$keys): array
    {
        $keys = $this->mergeKeys(...$keys);

        $all = $this->all();

        return array_filter($all, fn($key) => !in_array($key, $keys), ARRAY_FILTER_USE_KEY);
    }

    /**
     * merge keys
     *
     * @param string|array<string> ...$args
     * @return array<string>
     */
    protected function mergeKeys(string|array ...$args): array
    {
        $keys = [];

        foreach ($args as $key) {
            if (is_array($key)) {
                $keys = array_merge($keys, $key);
            } else {
                $keys[] = $key;
            }
        }

        return $keys;
    }
}
