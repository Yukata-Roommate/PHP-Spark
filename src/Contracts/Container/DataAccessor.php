<?php

declare(strict_types=1);

namespace Spark\Contracts\Container;

/**
 * Container Data Accessor Contract
 *
 * @package Spark\Contracts\Container
 */
interface DataAccessor
{
    /*----------------------------------------*
     * Accessor
     *----------------------------------------*/

    /**
     * Get property value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get(string $name, mixed $default = null): mixed;

    /**
     * Get validated property value
     *
     * @param string $name
     * @param mixed $default
     * @param callable|null $validator
     * @return mixed
     * @throws \Spark\Exceptions\Container\PropertyRequiredException
     * @throws \Spark\Exceptions\Container\PropertyInvalidException
     */
    public function validated(string $name, mixed $default = null, callable|null $validator = null): mixed;

    /**
     * Get property as string
     *
     * @param string $name
     * @param string|null $default
     * @return string
     * @throws \Spark\Exceptions\Container\PropertyRequiredException
     * @throws \Spark\Exceptions\Container\PropertyInvalidException
     */
    public function string(string $name, string|null $default = null): string;

    /**
     * Get property as nullable string
     *
     * @param string $name
     * @return string|null
     */
    public function nullableString(string $name): string|null;

    /**
     * Get property as integer
     *
     * @param string $name
     * @param int|null $default
     * @return int
     * @throws \Spark\Exceptions\Container\PropertyRequiredException
     * @throws \Spark\Exceptions\Container\PropertyInvalidException
     */
    public function int(string $name, int|null $default = null): int;

    /**
     * Get property as nullable integer
     *
     * @param string $name
     * @return int|null
     */
    public function nullableInt(string $name): int|null;

    /**
     * Get property as float
     *
     * @param string $name
     * @param float|null $default
     * @return float
     * @throws \Spark\Exceptions\Container\PropertyRequiredException
     * @throws \Spark\Exceptions\Container\PropertyInvalidException
     */
    public function float(string $name, float|null $default = null): float;

    /**
     * Get property as nullable float
     *
     * @param string $name
     * @return float|null
     */
    public function nullableFloat(string $name): float|null;

    /**
     * Get property as boolean
     *
     * @param string $name
     * @param bool|null $default
     * @return bool
     * @throws \Spark\Exceptions\Container\PropertyRequiredException
     * @throws \Spark\Exceptions\Container\PropertyInvalidException
     */
    public function bool(string $name, bool|null $default = null): bool;

    /**
     * Get property as nullable boolean
     *
     * @param string $name
     * @return bool|null
     */
    public function nullableBool(string $name): bool|null;

    /**
     * Get property as array
     *
     * @param string $name
     * @param array<mixed>|null $default
     * @return array<mixed>
     * @throws \Spark\Exceptions\Container\PropertyRequiredException
     * @throws \Spark\Exceptions\Container\PropertyInvalidException
     * @throws \Spark\Exceptions\Container\UnexpectedTypeException
     */
    public function array(string $name, array|null $default = null): array;

    /**
     * Get property as nullable array
     *
     * @param string $name
     * @return array<mixed>|null
     */
    public function nullableArray(string $name): array|null;

    /**
     * Get property as object
     *
     * @param string $name
     * @param object|null $default
     * @return object
     * @throws \Spark\Exceptions\Container\PropertyRequiredException
     * @throws \Spark\Exceptions\Container\PropertyInvalidException
     * @throws \Spark\Exceptions\Container\UnexpectedTypeException
     */
    public function object(string $name, object|null $default = null): object;

    /**
     * Get property as nullable object
     *
     * @param string $name
     * @return object|null
     */
    public function nullableObject(string $name): object|null;

    /**
     * Get property as enum
     *
     * @template T of \UnitEnum
     * @param string $name
     * @param class-string<T> $enumClass
     * @param T|null $default
     * @return T
     * @throws \Spark\Exceptions\Container\InvalidEnumClassException
     * @throws \Spark\Exceptions\Container\InvalidEnumDefaultException
     * @throws \Spark\Exceptions\Container\PropertyRequiredException
     * @throws \Spark\Exceptions\Container\InvalidEnumValueException
     */
    public function enum(string $name, string $enumClass, \UnitEnum|null $default = null): \UnitEnum;

    /**
     * Get property as nullable enum
     *
     * @template T of \UnitEnum
     * @param string $name
     * @param class-string<T> $enumClass
     * @return T|null
     */
    public function nullableEnum(string $name, string $enumClass): \UnitEnum|null;

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * Get all public properties
     *
     * @return array<string, mixed>
     */
    public function properties(): array;

    /**
     * Get all public property keys
     *
     * @return array<int, string>
     */
    public function propertyKeys(): array;

    /**
     * Get all public property values
     *
     * @return array<int, mixed>
     */
    public function propertyValues(): array;
}
