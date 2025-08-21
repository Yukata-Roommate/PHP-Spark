<?php

namespace Spark\Foundation\Entity;

/**
 * Data Accessor
 *
 * @package Spark\Foundation\Entity
 */
abstract class DataAccessor
{
    /**
     * get value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    abstract public function get(string $name, mixed $default = null): mixed;

    /**
     * get validated value
     *
     * @param string $name
     * @param mixed $default
     * @param callable|null $validator
     * @return mixed
     */
    public function validated(string $name, mixed $default = null, callable|null $validator = null): mixed
    {
        $property = $this->get($name, $default);

        if (is_null($property)) throw $this->requiredException($name);

        if (!is_null($validator) && !$validator($property)) throw $this->validationFailedException($name);

        return $property;
    }

    /**
     * make nullable method
     *
     * @param callable $method
     * @return mixed
     */
    protected function makeNullable(callable $method): mixed
    {
        try {
            return $method();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * get property as string
     *
     * @param string $name
     * @param string|null $default
     * @return string
     */
    public function string(string $name, string|null $default = null): string
    {
        return strval($this->validated($name, $default, fn($value) => !empty($value) && is_string($value)));
    }

    /**
     * get property as nullable string
     *
     * @param string $name
     * @return string|null
     */
    public function nullableString(string $name): string|null
    {
        return $this->makeNullable(fn() => $this->string($name));
    }

    /**
     * get property as int
     *
     * @param string $name
     * @param int|null $default
     * @return int
     */
    public function int(string $name, int|null $default = null): int
    {
        return intval($this->validated($name, $default, fn($value) => is_numeric($value) && intval($value) == $value));
    }

    /**
     * get property as nullable int
     *
     * @param string $name
     * @return int|null
     */
    public function nullableInt(string $name): int|null
    {
        return $this->makeNullable(fn() => $this->int($name));
    }

    /**
     * get property as float
     *
     * @param string $name
     * @param float|null $default
     * @return float
     */
    public function float(string $name, float|null $default = null): float
    {
        return floatval($this->validated($name, $default, fn($value) => is_numeric($value) && floatval($value) == $value));
    }

    /**
     * get property as nullable float
     *
     * @param string $name
     * @return float|null
     */
    public function nullableFloat(string $name): float|null
    {
        return $this->makeNullable(fn() => $this->float($name));
    }

    /**
     * get property as bool
     *
     * @param string $name
     * @param bool|null $default
     * @return bool
     */
    public function bool(string $name, bool|null $default = null): bool
    {
        return boolval($this->validated($name, $default, fn($value) => is_bool($value) || in_array($value, [0, 1, "0", "1", "true", "false", "TRUE", "FALSE", "on", "off", "yes", "no"], true)));
    }

    /**
     * get property as nullable bool
     *
     * @param string $name
     * @return bool|null
     */
    public function nullableBool(string $name): bool|null
    {
        return $this->makeNullable(fn() => $this->bool($name));
    }

    /**
     * get property as array
     *
     * @param string $name
     * @param array|null $default
     * @return array
     */
    public function array(string $name, array|null $default = null): array
    {
        $value = $this->validated($name, $default, fn($value) => is_array($value) || json_validate($value));

        if (is_array($value)) return $value;

        $decoded = json_decode($value, true, 512, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if (!is_array($decoded)) throw $this->unexpectedValueTypeException($name, $value, "array");

        return $decoded;
    }

    /**
     * get property as nullable array
     *
     * @param string $name
     * @return array|null
     */
    public function nullableArray(string $name): array|null
    {
        return $this->makeNullable(fn() => $this->array($name));
    }

    /**
     * get property as object
     *
     * @param string $name
     * @param object|null $default
     * @return object
     */
    public function object(string $name, object|null $default = null): object
    {
        $value = $this->validated($name, $default, fn($value) => is_object($value) || json_validate($value));

        if (is_object($value)) return $value;

        $decoded = json_decode($value, false, 512, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if (!is_object($decoded)) throw $this->unexpectedValueTypeException($name, $value, "object");

        return $decoded;
    }

    /**
     * get property as nullable object
     *
     * @param string $name
     * @return object|null
     */
    public function nullableObject(string $name): object|null
    {
        return $this->makeNullable(fn() => $this->object($name));
    }

    /**
     * get property as enum
     *
     * @param string $name
     * @param string $enumClass
     * @param \UnitEnum|null $default
     * @return \UnitEnum
     */
    public function enum(string $name, string $enumClass, \UnitEnum|null $default = null): \UnitEnum
    {
        if (!enum_exists($enumClass)) throw $this->exception("Enum class {$enumClass} does not exist.");

        if ($default !== null && !($default instanceof $enumClass)) throw $this->exception("Default value must be an instance of {$enumClass}.");

        $rawValue = $this->get($name);

        if ($rawValue === null) {
            if ($default !== null) return $default;

            throw $this->requiredException($name);
        }

        if (is_object($rawValue) && $rawValue instanceof $enumClass) return $rawValue;

        if (is_subclass_of($enumClass, \BackedEnum::class)) {
            $enum = $enumClass::tryFrom($rawValue);

            if ($enum !== null) return $enum;
        }

        if (is_string($rawValue)) {
            foreach ($enumClass::cases() as $case) {
                if ($case->name === $rawValue) return $case;
            }
        }

        throw $this->invalidValueException($name, $rawValue);
    }

    /**
     * get property as nullable enum
     *
     * @param string $name
     * @param string $enumClass
     * @return \UnitEnum|null
     */
    public function nullableEnum(string $name, string $enumClass): \UnitEnum|null
    {
        return $this->makeNullable(fn() => $this->enum($name, $enumClass));
    }

    /*----------------------------------------*
     * Exception
     *----------------------------------------*/

    /**
     * get exception
     *
     * @param string $message
     * @return \InvalidArgumentException
     */
    protected function exception(string $message): \InvalidArgumentException
    {
        return new \InvalidArgumentException($message);
    }

    /**
     * get required exception
     *
     * @param string $name
     * @return \InvalidArgumentException
     */
    protected function requiredException(string $name): \InvalidArgumentException
    {
        return $this->exception("{$name} is required.");
    }

    /**
     * get validation failed exception
     *
     * @param string $name
     * @return \InvalidArgumentException
     */
    protected function validationFailedException(string $name): \InvalidArgumentException
    {
        return $this->exception("Validation failed for {$name}.");
    }

    /**
     * get unexpected value type exception
     *
     * @param string $name
     * @param mixed $value
     * @param string $expectedType
     * @return \InvalidArgumentException
     */
    protected function unexpectedValueTypeException(string $name, mixed $value, string $expectedType): \InvalidArgumentException
    {
        $valueType = match (true) {
            is_null($value)   => "null",
            is_string($value) => "string",
            is_int($value)    => "int",
            is_float($value)  => "float",
            is_bool($value)   => "bool",
            is_array($value)  => "array",
            is_object($value) => get_class($value),
            default => gettype($value),
        };

        return $this->exception("Unexpected value type [{$valueType}] for {$name}. Expected type: {$expectedType}.");
    }

    /**
     * get invalid value exception
     *
     * @param string $name
     * @param mixed $value
     * @return \InvalidArgumentException
     */
    protected function invalidValueException(string $name, mixed $value): \InvalidArgumentException
    {
        $valueString = match (true) {
            is_null($value)   => "null",
            is_string($value) => "\"{$value}\"",
            is_int($value)    => strval($value),
            is_float($value)  => strval($value),
            is_bool($value)   => $value ? "true" : "false",
            is_array($value)  => json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            is_object($value) => get_class($value),
            default => gettype($value),
        };

        if (strlen($valueString) > 50) $valueString = substr($valueString, 0, 50) . "...";

        return $this->exception("Invalid value [{$valueString}] for {$name}.");
    }
}
