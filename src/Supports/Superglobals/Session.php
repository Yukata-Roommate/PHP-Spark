<?php

declare(strict_types=1);

namespace Spark\Supports\Superglobals;

use Spark\Foundation\Container\MutableReference;

/**
 * Session Reference
 *
 * @package Spark\Supports\Superglobals
 */
class Session extends MutableReference
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
        $this->start();

        return $_SESSION;
    }

    /*----------------------------------------*
     * Session Status
     *----------------------------------------*/

    /**
     * Get session status
     *
     * @return int
     */
    public function status(): int
    {
        return session_status();
    }

    /**
     * Whether session is started
     *
     * @return bool
     */
    public function isStarted(): bool
    {
        return $this->status() === PHP_SESSION_ACTIVE;
    }

    /**
     * Whether session is not started
     *
     * @return bool
     */
    public function isNotStarted(): bool
    {
        return $this->status() === PHP_SESSION_NONE;
    }

    /**
     * Whether session is disabled
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->status() === PHP_SESSION_DISABLED;
    }

    /**
     * Start session
     *
     * @return bool
     */
    public function start(): bool
    {
        return $this->isNotStarted() ? session_start() : true;
    }

    /**
     * Destroy session
     *
     * @return bool
     */
    public function destroy(): bool
    {
        return $this->isStarted() ? session_destroy() : true;
    }

    /*----------------------------------------*
     * Session ID
     *----------------------------------------*/

    /**
     * Get session id
     *
     * @return string
     */
    public function id(): string
    {
        return session_id();
    }

    /**
     * Set session id
     *
     * @param string $id
     * @return bool
     */
    public function setId(string $id): bool
    {
        return session_id($id);
    }

    /**
     * Regenerate session id
     *
     * @param bool $deleteOldSession
     * @return bool
     */
    public function regenerate(bool $deleteOldSession = false): bool
    {
        return session_regenerate_id($deleteOldSession);
    }

    /*----------------------------------------*
     * Csrf
     *----------------------------------------*/

    /**
     * Generate CSRF token
     *
     * @param string $key
     * @return string
     */
    public function generateCsrfToken(string $key = "csrf_token"): string
    {
        $token = bin2hex(random_bytes(32));

        $this->set($key, $token);

        return $token;
    }

    /**
     * Verify CSRF token
     *
     * @param string $token
     * @param string $key
     * @return bool
     */
    public function verifyCsrfToken(string $token, string $key = "csrf_token"): bool
    {
        return $this->has($key) && hash_equals($this->get($key), $token);
    }

    /*----------------------------------------*
     * Flash
     *----------------------------------------*/

    /**
     * Flash key prefix
     *
     * @var string
     */
    protected string $flashKeyPrefix = "_flash_";

    /**
     * Get flash key
     *
     * @param string $key
     * @return string
     */
    protected function flashKey(string $key): string
    {
        return $this->flashKeyPrefix . $key;
    }

    /**
     * Set flash data
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setFlash(string $key, $value): void
    {
        $this->set($this->flashKey($key), $value);
    }

    /**
     * Get flash data
     *
     * @param string $key
     * @return mixed
     */
    public function flash(string $key): mixed
    {
        $flashKey = $this->flashKey($key);

        if (!$this->has($flashKey)) return null;

        $value = $this->get($flashKey);

        $this->remove($flashKey);

        return $value;
    }
}
