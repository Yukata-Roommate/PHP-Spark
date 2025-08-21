<?php

namespace Spark\Supports\Global;

use Spark\Foundation\Entity\ReferenceHandler;

/**
 * Session Reference
 *
 * @package Spark\Supports\Global
 */
class Session extends ReferenceHandler
{
    /*----------------------------------------*
     * Reference
     *----------------------------------------*/

    /**
     * get reference
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
     * get session status
     *
     * @return int
     */
    public function status(): int
    {
        return session_status();
    }

    /**
     * whether session is started
     *
     * @return bool
     */
    public function isStarted(): bool
    {
        return $this->status() === PHP_SESSION_ACTIVE;
    }

    /**
     * whether session is not started
     *
     * @return bool
     */
    public function isNotStarted(): bool
    {
        return $this->status() === PHP_SESSION_NONE;
    }

    /**
     * whether session is disabled
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->status() === PHP_SESSION_DISABLED;
    }

    /**
     * start session
     *
     * @return bool
     */
    public function start(): bool
    {
        return $this->isNotStarted() ? session_start() : true;
    }

    /**
     * destroy session
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
     * get session id
     *
     * @return string
     */
    public function id(): string
    {
        return session_id();
    }

    /**
     * set session id
     *
     * @param string $id
     * @return bool
     */
    public function setId(string $id): bool
    {
        return session_id($id);
    }

    /**
     * regenerate session id
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
     * generate CSRF token
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
     * verify CSRF token
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
     * flash key prefix
     *
     * @var string
     */
    protected string $flashKeyPrefix = "_flash_";

    /**
     * get flash key
     *
     * @param string $key
     * @return string
     */
    protected function flashKey(string $key): string
    {
        return $this->flashKeyPrefix . $key;
    }

    /**
     * set flash data
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
     * get flash data
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
