<?php

declare(strict_types=1);

namespace Spark\Concerns\Enum;

use Spark\Concerns\Enum\EnumPlus;
use Spark\Exceptions\Enum\NotBackedEnumException;

/**
 * Backed Enum Plus
 *
 * @package Spark\Concerns\Enum
 *
 * @method static static from(int|string $value)
 * @method static static|null tryFrom(int|string $value)
 */
trait BackedPlus
{
    use EnumPlus {
        EnumPlus::assertEnum as assertPureEnum;
        EnumPlus::isEqual as pureIsEqual;
    }

    /*----------------------------------------*
     * Assert Enum
     *----------------------------------------*/

    /**
     * Assert class uses BackedEnum
     *
     * @return void
     * @throws \Spark\Exceptions\Enum\NotBackedEnumException
     */
    protected static function assertEnum(): void
    {
        static::assertPureEnum();

        if (!is_subclass_of(static::class, \BackedEnum::class)) throw new NotBackedEnumException(static::class);
    }

    /*----------------------------------------*
     * Value
     *----------------------------------------*/

    /**
     * Get value as string
     *
     * @return string
     * @throws \Spark\Exceptions\Enum\NotBackedEnumException
     */
    public function asString(): string
    {
        static::assertEnum();

        return (string)$this->value;
    }

    /*----------------------------------------*
     * Values
     *----------------------------------------*/

    /**
     * Get values from cases
     *
     * @return array
     * @throws \Spark\Exceptions\Enum\NotBackedEnumException
     */
    public static function values(): array
    {
        static::assertEnum();

        return array_column(static::cases(), "value");
    }

    /**
     * Get value at index
     *
     * @param int $index
     * @return int|string
     * @throws \Spark\Exceptions\Enum\InvalidIndexException
     * @throws \Spark\Exceptions\Enum\NotBackedEnumException
     */
    public static function valueAt(int $index): int|string
    {
        return static::caseAt($index)->value;
    }

    /**
     * Get value at index safely
     *
     * @param int $index
     * @return int|string|null
     */
    public static function tryValueAt(int $index): int|string|null
    {
        return static::tryCaseAt($index)?->value;
    }

    /**
     * Get value at index cyclically
     *
     * @param int $index
     * @return int|string
     * @throws \Spark\Exceptions\Enum\NotBackedEnumException
     */
    public static function valueAtCyclic(int $index): int|string
    {
        return static::caseAtCyclic($index)->value;
    }

    /*----------------------------------------*
     * Values Reverse
     *----------------------------------------*/

    /**
     * Get values in reverse order
     *
     * @return array
     * @throws \Spark\Exceptions\Enum\NotBackedEnumException
     */
    public static function valuesReverse(): array
    {
        return array_reverse(static::values());
    }

    /**
     * Get value at index in reverse order
     *
     * @param int $index
     * @return int|string
     * @throws \Spark\Exceptions\Enum\InvalidIndexException
     * @throws \Spark\Exceptions\Enum\NotBackedEnumException
     */
    public static function valueAtReverse(int $index): int|string
    {
        return static::caseAtReverse($index)->value;
    }

    /**
     * Get value at index in reverse order safely
     *
     * @param int $index
     * @return int|string|null
     */
    public static function tryValueAtReverse(int $index): int|string|null
    {
        return static::tryCaseAtReverse($index)?->value;
    }

    /**
     * Get value at index in reverse order cyclically
     *
     * @param int $index
     * @return int|string
     * @throws \Spark\Exceptions\Enum\NotBackedEnumException
     */
    public static function valueAtReverseCyclic(int $index): int|string
    {
        return static::caseAtReverseCyclic($index)->value;
    }

    /*----------------------------------------*
     * Compare
     *----------------------------------------*/

    /**
     * Whether value is in enum
     *
     * @param int|string $value
     * @return bool
     * @throws \Spark\Exceptions\Enum\NotBackedEnumException
     */
    public static function has(int|string $value): bool
    {
        static::assertEnum();

        return static::tryFrom($value) !== null;
    }

    /**
     * Whether value is not in enum
     *
     * @param int|string $value
     * @return bool
     * @throws \Spark\Exceptions\Enum\NotBackedEnumException
     */
    public static function hasNot(int|string $value): bool
    {
        return !static::has($value);
    }

    /**
     * Whether enum is equal to another enum
     *
     * @param mixed $enum
     * @return bool
     */
    public function isEqual(mixed $enum): bool
    {
        if (!$enum instanceof \BackedEnum) return false;

        return $this->pureIsEqual($enum) && $this->value === $enum->value;
    }
}
