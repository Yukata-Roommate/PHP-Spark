<?php

declare(strict_types=1);

namespace Spark\Foundation\Container;

use Spark\Contracts\Container\DataAccessor as DataAccessorContract;

use Spark\Exceptions\Container\PropertyRequiredException;
use Spark\Exceptions\Container\PropertyInvalidException;
use Spark\Exceptions\Container\UnexpectedTypeException;
use Spark\Exceptions\Container\InvalidEnumClassException;
use Spark\Exceptions\Container\InvalidEnumValueException;
use Spark\Exceptions\Container\InvalidEnumDefaultException;
use Spark\Exceptions\Container\ValidationException;

/**
 * Container Data Accessor
 *
 * @package Spark\Foundation\Container
 */
abstract class DataAccessor implements DataAccessorContract
{
    /*----------------------------------------*
     * Accessor
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    abstract public function get(string $name, mixed $default = null): mixed;

    /**
     * {@inheritDoc}
     */
    public function validated(string $name, mixed $default = null, callable|null $validator = null): mixed
    {
        $property = $this->get($name, $default);

        if (is_null($property)) throw new PropertyRequiredException($name);

        if (!is_null($validator) && !$validator($property)) throw new PropertyInvalidException($name);

        return $property;
    }

    /**
     * Make method call nullable by catching exceptions
     *
     * @template T
     * @param callable(): T $method
     * @return T|null
     */
    protected function makeNullable(callable $method): mixed
    {
        try {
            return $method();
        } catch (ValidationException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function string(string $name, string|null $default = null): string
    {
        return strval($this->validated($name, $default, fn($v): bool => is_string($v) || is_numeric($v)));
    }

    /**
     * {@inheritDoc}
     */
    public function nullableString(string $name): string|null
    {
        return $this->makeNullable(fn() => $this->string($name));
    }

    /**
     * {@inheritDoc}
     */
    public function int(string $name, int|null $default = null): int
    {
        return intval($this->validated($name, $default, fn($v): bool => is_int($v) || (is_numeric($v) && (int) $v == $v)));
    }

    /**
     * {@inheritDoc}
     */
    public function nullableInt(string $name): int|null
    {
        return $this->makeNullable(fn() => $this->int($name));
    }

    /**
     * {@inheritDoc}
     */
    public function float(string $name, float|null $default = null): float
    {
        return floatval($this->validated($name, $default, fn($v): bool => is_float($v) || is_int($v) || is_numeric($v)));
    }

    /**
     * {@inheritDoc}
     */
    public function nullableFloat(string $name): float|null
    {
        return $this->makeNullable(fn() => $this->float($name));
    }

    /**
     * {@inheritDoc}
     */
    public function bool(string $name, bool|null $default = null): bool
    {
        return filter_var($this->validated($name, $default, fn($v): bool => is_bool($v) || in_array($v, [0, 1, "0", "1", "true", "false", "TRUE", "FALSE", "on", "off", "yes", "no"], true)), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * {@inheritDoc}
     */
    public function nullableBool(string $name): bool|null
    {
        return $this->makeNullable(fn() => $this->bool($name));
    }

    /**
     * {@inheritDoc}
     */
    public function array(string $name, array|null $default = null): array
    {
        $value = $this->validated($name, $default, fn($v): bool => is_array($v) || (is_string($v) && json_validate($v)));

        if (is_array($value)) return $value;

        $decoded = json_decode($value, true, 512, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if (!is_array($decoded)) throw new UnexpectedTypeException($name, "array", gettype($value));

        return $decoded;
    }

    /**
     * {@inheritDoc}
     */
    public function nullableArray(string $name): array|null
    {
        return $this->makeNullable(fn() => $this->array($name));
    }

    /**
     * {@inheritDoc}
     */
    public function object(string $name, object|null $default = null): object
    {
        $value = $this->validated($name, $default, fn($v): bool => is_object($v) || (is_string($v) && json_validate($v)));

        if (is_object($value)) return $value;

        $decoded = json_decode($value, false, 512, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if (!is_object($decoded)) throw new UnexpectedTypeException($name, "object", gettype($value));

        return $decoded;
    }

    /**
     * {@inheritDoc}
     */
    public function nullableObject(string $name): object|null
    {
        return $this->makeNullable(fn() => $this->object($name));
    }

    /**
     * {@inheritDoc}
     */
    public function enum(string $name, string $enumClass, \UnitEnum|null $default = null): \UnitEnum
    {
        if (!enum_exists($enumClass)) throw new InvalidEnumClassException($enumClass);

        if ($default !== null && !($default instanceof $enumClass)) throw new InvalidEnumDefaultException($enumClass);

        $rawValue = $this->get($name);

        if ($rawValue === null) {
            if ($default !== null) return $default;

            throw new PropertyRequiredException($name);
        }

        if (is_object($rawValue) && $rawValue instanceof $enumClass) return $rawValue;

        if (is_subclass_of($enumClass, \BackedEnum::class)) {
            /** @var \BackedEnum $enumClass */
            $enum = $enumClass::tryFrom($rawValue);

            if ($enum !== null) return $enum;
        }

        if (is_string($rawValue)) {
            foreach ($enumClass::cases() as $case) {
                if ($case->name === $rawValue) return $case;
            }
        }

        throw new InvalidEnumValueException($enumClass, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function nullableEnum(string $name, string $enumClass): \UnitEnum|null
    {
        return $this->makeNullable(fn() => $this->enum($name, $enumClass));
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function properties(): array
    {
        return $this->getObjectProperties($this);
    }

    /**
     * {@inheritDoc}
     */
    public function propertyKeys(): array
    {
        return array_keys($this->properties());
    }

    /**
     * {@inheritDoc}
     */
    public function propertyValues(): array
    {
        return array_values($this->properties());
    }

    /*----------------------------------------*
     * Collection
     *----------------------------------------*/

    /**
     * Merge variadic key arguments into single array
     *
     * @param string|array<int, string> ...$args
     * @return array<int, string>
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

        return array_values(array_unique($keys));
    }

    /**
     * Get object properties as array
     *
     * @param object $object
     * @return array<string, mixed>
     */
    protected function getObjectProperties(object $object): array
    {
        if ($object instanceof \stdClass) return get_object_vars($object);

        $reflector = new \ReflectionObject($object);

        $properties = [];

        foreach ($reflector->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->isStatic()) continue;

            if (!$property->isInitialized($object)) continue;

            $properties[$property->getName()] = $property->getValue($object);
        }

        return $properties;
    }
}
