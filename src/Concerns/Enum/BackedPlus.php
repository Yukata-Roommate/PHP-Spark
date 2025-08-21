<?php

namespace Spark\Concerns\Enums;

use Spark\Concerns\Enums\EnumPlus;

/**
 * Backed Enum Plus
 *
 * @package Spark\Concerns\Enums
 *
 * @method static \BackedEnum from(int|string $value)
 * @method static \BackedEnum|null tryFrom(int|string $value)
 */
trait BackedPlus
{
    use EnumPlus {
        EnumPlus::assertEnum as assertPureEnum;
        EnumPlus::equal as pureEqual;
    }

    /*----------------------------------------*
     * Assert Enum
     *----------------------------------------*/

    /**
     * assert class uses Enum
     *
     * @return void
     */
    protected static function assertEnum(): void
    {
        self::assertPureEnum();

        if (!is_subclass_of(self::class, \BackedEnum::class)) throw new \BadMethodCallException("this trait can only be used in Backed Enum");
    }

    /*----------------------------------------*
     * Value
     *----------------------------------------*/

    /**
     * get value as string
     *
     * @return string
     */
    public function strval(): string
    {
        self::assertEnum();

        return (string)$this->value;
    }

    /*----------------------------------------*
     * Values
     *----------------------------------------*/

    /**
     * get values from cases
     *
     * @return array
     */
    public static function values(): array
    {
        self::assertEnum();

        return array_column(self::cases(), "value");
    }

    /**
     * get value at index
     *
     * @param int $index
     * @return int|string
     */
    public static function valueAt(int $index): int|string
    {
        return self::caseAt($index)->value;
    }

    /**
     * get value at index safely
     *
     * @param int $index
     * @return int|string|null
     */
    public static function tryValueAt(int $index): int|string|null
    {
        return self::tryCaseAt($index)?->value ?? null;
    }

    /**
     * get value at index cyclically
     *
     * @param int $index
     * @return int|string
     */
    public static function valueAtCyclic(int $index): int|string
    {
        return self::valueAt($index % count(self::values()));
    }

    /*----------------------------------------*
     * Values Reverse
     *----------------------------------------*/

    /**
     * get values in reverse order
     *
     * @return array
     */
    public static function valuesReverse(): array
    {
        return array_reverse(self::values());
    }

    /**
     * get value at index in reverse order
     *
     * @param int $index
     * @return int|string
     */
    public static function valueAtReverse(int $index): int|string
    {
        return self::caseAtReverse($index)->value;
    }

    /**
     * get value at index in reverse order safely
     *
     * @param int $index
     * @return int|string|null
     */
    public static function tryValueAtReverse(int $index): int|string|null
    {
        return self::tryCaseAtReverse($index)?->value ?? null;
    }

    /**
     * get value at index in reverse order cyclically
     *
     * @param int $index
     * @return int|string
     */
    public static function valueAtReverseCyclic(int $index): int|string
    {
        return self::valueAtReverse($index % count(self::valuesReverse()));
    }

    /*----------------------------------------*
     * Compare
     *----------------------------------------*/

    /**
     * whether value is in enum
     *
     * @param int|string $value
     * @return bool
     */
    public static function has(int|string $value): bool
    {
        self::assertEnum();

        return self::tryFrom($value) !== null;
    }

    /**
     * whether value is not in enum
     *
     * @param int|string $value
     * @return bool
     */
    public static function hasNot(int|string $value): bool
    {
        return !self::has($value);
    }

    /**
     * whether value is equal to self
     *
     * @param \BackedEnum $enum
     * @return bool
     */
    public function equal(\BackedEnum $enum): bool
    {
        return $this->pureEqual($enum) && $this->value === $enum->value;
    }
}
