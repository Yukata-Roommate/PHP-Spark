<?php

declare(strict_types=1);

namespace Spark\Supports\Superglobals;

use Spark\Foundation\Container\Reference;

/**
 * Cookie Reference
 *
 * @package Spark\Supports\Superglobals
 */
class Cookie extends Reference
{
    /*----------------------------------------*
     * Reference
     *----------------------------------------*/

    /**
     * Get reference
     *
     * @return array
     */
    protected function &reference(): array
    {
        return $_COOKIE;
    }

    /*----------------------------------------*
     * Set
     *----------------------------------------*/

    /**
     * Set value
     *
     * @param string $key
     * @param string $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     * @return void
     */
    public function set(string $key, string $value, int $expire = 0, string $path = "/", string $domain = "", bool $secure = false, bool $httponly = false): void
    {
        $result = setcookie($key, $value, $expire, $path, $domain, $secure, $httponly);

        if (!$result) throw new \RuntimeException("Failed to set cookie: {$key}");

        $reference = &$this->reference();

        $reference[$key] = $value;
    }

    /**
     * Set json value
     *
     * @param string $key
     * @param array $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     * @return void
     */
    public function setJson(string $key, array $value, int $expire = 0, string $path = "/", string $domain = "", bool $secure = false, bool $httponly = false): void
    {
        $jsonValue = json_encode($value);

        if ($jsonValue === false) throw new \RuntimeException("Failed to encode value to JSON: " . json_last_error_msg());

        $this->set($key, $jsonValue, $expire, $path, $domain, $secure, $httponly);
    }

    /*----------------------------------------*
     * Remove
     *----------------------------------------*/

    /**
     * Remove value
     *
     * @param string $key
     * @param string $path
     * @param string $domain
     * @return void
     */
    public function remove(string $key, string $path = "/", string $domain = ""): void
    {
        if (!$this->has($key)) throw new \RuntimeException("Cookie not found: {$key}");

        $result = setcookie($key, "", time() - 3600, $path, $domain);

        if (!$result) throw new \RuntimeException("Failed to remove cookie: {$key}");

        $reference = &$this->reference();

        unset($reference[$key]);
    }
}
