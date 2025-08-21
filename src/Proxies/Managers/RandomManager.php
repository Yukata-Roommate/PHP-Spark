<?php

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\ProxyManager;

use Random\Randomizer;
use Random\IntervalBoundary;

/**
 * Random Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class RandomManager extends ProxyManager
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * init manager
     *
     * @return void
     */
    protected function init(): void
    {
        $this->randomizer = new Randomizer();
    }

    /**
     * randomizer
     *
     * @var \Random\Randomizer
     */
    protected Randomizer $randomizer;

    /*----------------------------------------*
     * Text
     *----------------------------------------*/

    /**
     * get random string
     *
     * @param string $source
     * @param int $length
     * @return string
     */
    public function string(string $source, int $length = 16): string
    {
        return $this->randomizer->getBytesFromString($source, $length);
    }

    /**
     * get random alphabet
     *
     * @param int $length
     * @return string
     */
    public function alphabet(int $length = 16): string
    {
        return $this->string("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", $length);
    }

    /**
     * get random lower case alphabet
     *
     * @param int $length
     * @return string
     */
    public function alphabetLower(int $length = 16): string
    {
        return $this->string("abcdefghijklmnopqrstuvwxyz", $length);
    }

    /**
     * get random upper case alphabet
     *
     * @param int $length
     * @return string
     */
    public function alphabetUpper(int $length = 16): string
    {
        return $this->string("ABCDEFGHIJKLMNOPQRSTUVWXYZ", $length);
    }

    /**
     * get random number
     *
     * @param int $length
     * @return string
     */
    public function number(int $length = 16): string
    {
        return $this->string("0123456789", $length);
    }

    /**
     * get random alphanumeric
     *
     * @param int $length
     * @return string
     */
    public function alphanumeric(int $length = 16): string
    {
        return $this->string("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789", $length);
    }

    /**
     * get random lower case alphanumeric
     *
     * @param int $length
     * @return string
     */
    public function alphanumericLower(int $length = 16): string
    {
        return $this->string("abcdefghijklmnopqrstuvwxyz0123456789", $length);
    }

    /**
     * get random upper case alphanumeric
     *
     * @param int $length
     * @return string
     */
    public function alphanumericUpper(int $length = 16): string
    {
        return $this->string("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789", $length);
    }

    /**
     * get random password
     *
     * @param int $length
     * @param string $symbols
     * @return string
     */
    public function password(int $length = 16, string $symbols = ""): string
    {
        return $this->string("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789{$symbols}", $length);
    }

    /*----------------------------------------*
     * Number
     *----------------------------------------*/

    /**
     * get random int
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    public function int(int $min = 0, int $max = PHP_INT_MAX): int
    {
        return $this->randomizer->getInt($min, $max);
    }

    /**
     * get random float
     *
     * @param float $min
     * @param float $max
     * @param int $decimals
     * @return float
     */
    public function float(float $min = 0, float $max = 1, int $decimals = 2): float
    {
        $random = $this->randomizer->getFloat($min, $max, IntervalBoundary::ClosedClosed);

        return round($random, $decimals);
    }

    /*----------------------------------------*
     * Bool
     *----------------------------------------*/

    /**
     * get random bool
     *
     * @param string|int|float $probability
     * @param bool $isPercent
     * @return bool
     */
    public function bool(string|int|float $probability = 0.5, bool $isPercent = false): bool
    {
        if (is_string($probability)) $probability = (float)$probability;

        if ($probability <= 0) return false;

        if (!$isPercent && $probability >= 1) return true;

        if ($isPercent) $probability /= 100;

        return $this->randomizer->nextFloat() < $probability;
    }
}
