<?php

declare(strict_types=1);

namespace Spark\Concerns\Enum;

use Spark\Exceptions\Enum\ValueException;
use Spark\Exceptions\Enum\NotUnitEnumException;
use Spark\Exceptions\Enum\InvalidNameException;
use Spark\Exceptions\Enum\InvalidIndexException;

/**
 * Unit Enum Plus
 *
 * @package Spark\Concerns\Enum
 *
 * @method static array cases()
 */
trait EnumPlus
{
    /*----------------------------------------*
     * Assert Enum
     *----------------------------------------*/

    /**
     * Assert class uses Enum
     *
     * @return void
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    protected static function assertEnum(): void
    {
        if (!enum_exists(static::class)) throw new NotUnitEnumException(static::class);
    }

    /*----------------------------------------*
     * From Name
     *----------------------------------------*/

    /**
     * Make enum from name
     *
     * @param int|string $name
     * @return static
     * @throws \Spark\Exceptions\Enum\InvalidNameException
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function fromName(int|string $name): static
    {
        static::assertEnum();

        foreach (static::cases() as $case) {
            if ($name === $case->name) return $case;
        }

        throw new InvalidNameException(static::class, $name);
    }

    /**
     * Make enum from name safely
     *
     * @param int|string $name
     * @return static|null
     */
    public static function tryFromName(int|string $name): static|null
    {
        try {
            return static::fromName($name);
        } catch (ValueException $error) {
            return null;
        }
    }

    /*----------------------------------------*
     * Cases
     *----------------------------------------*/

    /**
     * Get cases count
     *
     * @return int
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function count(): int
    {
        static::assertEnum();

        return count(static::cases());
    }

    /**
     * Get case at index
     *
     * @param int $index
     * @return static
     * @throws \Spark\Exceptions\Enum\InvalidIndexException
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function caseAt(int $index): static
    {
        static::assertEnum();

        $cases = static::cases();

        $count = count($cases);

        if ($index < 0 || $index >= $count) throw new InvalidIndexException(static::class, $index, $count);

        return $cases[$index];
    }

    /**
     * Get case at index safely
     *
     * @param int $index
     * @return static|null
     */
    public static function tryCaseAt(int $index): static|null
    {
        try {
            return static::caseAt($index);
        } catch (ValueException $error) {
            return null;
        }
    }

    /**
     * Get case at index cyclically
     *
     * @param int $index
     * @return static
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function caseAtCyclic(int $index): static
    {
        $count = static::count();

        $normalizedIndex = (($index % $count) + $count) % $count;

        return static::cases()[$normalizedIndex];
    }

    /*----------------------------------------*
     * Cases Reverse
     *----------------------------------------*/

    /**
     * Get cases in reverse order
     *
     * @return array
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function casesReverse(): array
    {
        static::assertEnum();

        return array_reverse(static::cases());
    }

    /**
     * Get case at index in reverse order
     *
     * @param int $index
     * @return static
     * @throws \Spark\Exceptions\Enum\InvalidIndexException
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function caseAtReverse(int $index): static
    {
        $cases = static::casesReverse();

        $count = count($cases);

        if ($index < 0 || $index >= $count) throw new InvalidIndexException(static::class, $index, $count);

        return $cases[$index];
    }

    /**
     * Get case at index in reverse order safely
     *
     * @param int $index
     * @return static|null
     */
    public static function tryCaseAtReverse(int $index): static|null
    {
        try {
            return static::caseAtReverse($index);
        } catch (ValueException $error) {
            return null;
        }
    }

    /**
     * Get case at index in reverse order cyclically
     *
     * @param int $index
     * @return static
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function caseAtReverseCyclic(int $index): static
    {
        $count = static::count();

        $normalizedIndex = (($index % $count) + $count) % $count;

        return static::casesReverse()[$normalizedIndex];
    }

    /*----------------------------------------*
     * Names
     *----------------------------------------*/

    /**
     * Get names from cases
     *
     * @return array
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function names(): array
    {
        static::assertEnum();

        return array_column(static::cases(), "name");
    }

    /**
     * Get name at index
     *
     * @param int $index
     * @return string
     * @throws \Spark\Exceptions\Enum\InvalidIndexException
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function nameAt(int $index): string
    {
        return static::caseAt($index)->name;
    }

    /**
     * Get name at index safely
     *
     * @param int $index
     * @return string|null
     */
    public static function tryNameAt(int $index): string|null
    {
        return static::tryCaseAt($index)?->name;
    }

    /**
     * Get name at index cyclically
     *
     * @param int $index
     * @return string
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function nameAtCyclic(int $index): string
    {
        return static::caseAtCyclic($index)->name;
    }

    /*----------------------------------------*
     * Names Reverse
     *----------------------------------------*/

    /**
     * Get names in reverse order
     *
     * @return array
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function namesReverse(): array
    {
        return array_reverse(static::names());
    }

    /**
     * Get name at index in reverse order
     *
     * @param int $index
     * @return string
     * @throws \Spark\Exceptions\Enum\InvalidIndexException
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function nameAtReverse(int $index): string
    {
        return static::caseAtReverse($index)->name;
    }

    /**
     * Get name at index in reverse order safely
     *
     * @param int $index
     * @return string|null
     */
    public static function tryNameAtReverse(int $index): string|null
    {
        return static::tryCaseAtReverse($index)?->name;
    }

    /**
     * Get name at index in reverse order cyclically
     *
     * @param int $index
     * @return string
     * @throws \Spark\Exceptions\Enum\NotUnitEnumException
     */
    public static function nameAtReverseCyclic(int $index): string
    {
        return static::caseAtReverseCyclic($index)->name;
    }

    /*----------------------------------------*
     * Compare
     *----------------------------------------*/

    /**
     * Whether name is in enum
     *
     * @param int|string $name
     * @return bool
     */
    public static function hasName(int|string $name): bool
    {
        return static::tryFromName($name) !== null;
    }

    /**
     * Whether name is not in enum
     *
     * @param int|string $name
     * @return bool
     */
    public static function hasNotName(int|string $name): bool
    {
        return !static::hasName($name);
    }

    /**
     * Whether enum is equal to another enum
     *
     * @param mixed $enum
     * @return bool
     */
    public function isEqual(mixed $enum): bool
    {
        static::assertEnum();

        if (!$enum instanceof \UnitEnum) return false;

        return $this->name === $enum->name && static::class === $enum::class;
    }
}
