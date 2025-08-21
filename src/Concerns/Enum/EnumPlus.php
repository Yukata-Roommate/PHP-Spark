<?php

namespace Spark\Concerns\Enums;

/**
 * Unit Enum Plus
 *
 * @package Spark\Concerns\Enums
 *
 * @method static array cases()
 */
trait EnumPlus
{
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
        if (!enum_exists(self::class)) throw new \BadMethodCallException("this trait can only be used in Enum");
    }

    /*----------------------------------------*
     * From Name
     *----------------------------------------*/

    /**
     * make enum from name
     *
     * @param int|string $name
     * @return static
     */
    public static function fromName(int|string $name): static
    {
        self::assertEnum();

        foreach (self::cases() as $case) {
            if ($name === $case->name) return $case;
        }

        throw new \ValueError("{$name} is not a valid backing name for enum " . self::class);
    }

    /**
     * make enum from name
     * if failed, return null
     *
     * @param int|string $name
     * @return static|null
     */
    public static function tryFromName(int|string $name): static|null
    {
        try {
            return self::fromName($name);
        } catch (\ValueError $error) {
            return null;
        }
    }

    /*----------------------------------------*
     * Cases
     *----------------------------------------*/

    /**
     * get cases count
     *
     * @return int
     */
    public static function count(): int
    {
        self::assertEnum();

        return count(self::cases());
    }

    /**
     * get case at index
     *
     * @param int $index
     * @return static
     */
    public static function caseAt(int $index): static
    {
        self::assertEnum();

        if ($index < 0) throw new \OutOfBoundsException("Index {$index} is out of bounds for enum " . self::class);

        $cases = self::cases();

        if (!isset($cases[$index])) throw new \OutOfBoundsException("Index {$index} is out of bounds for enum " . self::class);

        return $cases[$index];
    }

    /**
     * get case at index safely
     *
     * @param int $index
     * @return static|null
     */
    public static function tryCaseAt(int $index): static|null
    {
        try {
            return self::caseAt($index);
        } catch (\OutOfBoundsException $error) {
            return null;
        }
    }

    /**
     * get case at index cyclically
     *
     * @param int $index
     * @return static
     */
    public static function caseAtCyclic(int $index): static
    {
        return self::caseAt($index % count(self::cases()));
    }

    /*----------------------------------------*
     * Cases Reverse
     *----------------------------------------*/

    /**
     * get cases in reverse order
     *
     * @return array
     */
    public static function casesReverse(): array
    {
        self::assertEnum();

        return array_reverse(self::cases());
    }

    /**
     * get case at index in reverse order
     *
     * @param int $index
     * @return static
     */
    public static function caseAtReverse(int $index): static
    {
        if ($index < 0) throw new \OutOfBoundsException("Index {$index} is out of bounds for enum " . self::class);

        $cases = self::casesReverse();

        if (!isset($cases[$index])) throw new \OutOfBoundsException("Index {$index} is out of bounds for enum " . self::class);

        return $cases[$index];
    }

    /**
     * get case at index in reverse order safely
     *
     * @param int $index
     * @return static|null
     */
    public static function tryCaseAtReverse(int $index): static|null
    {
        try {
            return self::caseAtReverse($index);
        } catch (\OutOfBoundsException $error) {
            return null;
        }
    }

    /**
     * get case at index in reverse order cyclically
     *
     * @param int $index
     * @return static
     */
    public static function caseAtReverseCyclic(int $index): static
    {
        return self::caseAtReverse($index % count(self::casesReverse()));
    }

    /*----------------------------------------*
     * Names
     *----------------------------------------*/

    /**
     * get names from cases
     *
     * @return array
     */
    public static function names(): array
    {
        self::assertEnum();

        return array_column(self::cases(), "name");
    }

    /**
     * get name at index
     *
     * @param int $index
     * @return string
     */
    public static function nameAt(int $index): string
    {
        return self::caseAt($index)->name;
    }

    /**
     * get name at index safely
     *
     * @param int $index
     * @return string|null
     */
    public static function tryNameAt(int $index): string|null
    {
        return self::tryCaseAt($index)?->name ?? null;
    }

    /**
     * get name at index cyclically
     *
     * @param int $index
     * @return string
     */
    public static function nameAtCyclic(int $index): string
    {
        return self::nameAt($index % count(self::names()));
    }

    /*----------------------------------------*
     * Names Reverse
     *----------------------------------------*/

    /**
     * get names in reverse order
     *
     * @return array
     */
    public static function namesReverse(): array
    {
        return array_reverse(self::names());
    }

    /**
     * get name at index in reverse order
     *
     * @param int $index
     * @return string
     */
    public static function nameAtReverse(int $index): string
    {
        return self::caseAtReverse($index)->name;
    }

    /**
     * get name at index in reverse order safely
     *
     * @param int $index
     * @return string|null
     */
    public static function tryNameAtReverse(int $index): string|null
    {
        return self::tryCaseAtReverse($index)?->name ?? null;
    }

    /**
     * get name at index in reverse order cyclically
     *
     * @param int $index
     * @return string
     */
    public static function nameAtReverseCyclic(int $index): string
    {
        return self::nameAtReverse($index % count(self::namesReverse()));
    }

    /*----------------------------------------*
     * Compare
     *----------------------------------------*/

    /**
     * whether name is in enum
     *
     * @param int|string $name
     * @return bool
     */
    public static function hasName(int|string $name): bool
    {
        return self::tryFromName($name) !== null;
    }

    /**
     * whether name is not in enum
     *
     * @param int|string $name
     * @return bool
     */
    public static function hasNotName(int|string $name): bool
    {
        return !self::hasName($name);
    }

    /**
     * whether value is equal to self
     *
     * @param \UnitEnum
     * @return bool
     */
    public function equal(\UnitEnum $enum): bool
    {
        self::assertEnum();

        return $this->name === $enum->name;
    }
}
