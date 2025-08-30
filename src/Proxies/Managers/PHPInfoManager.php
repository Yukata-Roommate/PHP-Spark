<?php

declare(strict_types=1);

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\ProxyManager;

/**
 * PHPInfo Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class PHPInfoManager extends ProxyManager
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Init manager
     *
     * @return void
     */
    protected function init(): void {}

    /*----------------------------------------*
     * Show
     *----------------------------------------*/

    /**
     * Show phpinfo()
     *
     * @param int|null $flags
     * @return bool
     */
    public function show(int|null $flags = null): bool
    {
        if (!$this->isValidFlags($flags)) $flags = INFO_ALL;

        return phpinfo($flags);
    }

    /**
     * Show all in phpinfo()
     *
     * @return bool
     */
    public function showAll(): bool
    {
        return $this->show(INFO_ALL);
    }

    /**
     * Show general in phpinfo()
     *
     * @return bool
     */
    public function showGeneral(): bool
    {
        return $this->show(INFO_GENERAL);
    }

    /**
     * Show credits in phpinfo()
     *
     * @return bool
     */
    public function showCredits(): bool
    {
        return $this->show(INFO_CREDITS);
    }

    /**
     * Show configuration in phpinfo()
     *
     * @return bool
     */
    public function showConfiguration(): bool
    {
        return $this->show(INFO_CONFIGURATION);
    }

    /**
     * Show modules in phpinfo()
     *
     * @return bool
     */
    public function showModules(): bool
    {
        return $this->show(INFO_MODULES);
    }

    /**
     * Show environment in phpinfo()
     *
     * @return bool
     */
    public function showEnvironment(): bool
    {
        return $this->show(INFO_ENVIRONMENT);
    }

    /**
     * Show variables in phpinfo()
     *
     * @return bool
     */
    public function showVariables(): bool
    {
        return $this->show(INFO_VARIABLES);
    }

    /**
     * Show license in phpinfo()
     *
     * @return bool
     */
    public function showLicense(): bool
    {
        return $this->show(INFO_LICENSE);
    }

    /*----------------------------------------*
     * Get
     *----------------------------------------*/

    /**
     * Get phpinfo() as string
     *
     * @param int|null $flags
     * @return string
     */
    public function get(int|null $flags = null): bool
    {
        ob_start();

        ob_implicit_flush(false);

        $this->show($flags);

        $contents = ob_get_contents();

        ob_end_clean();

        return $contents;
    }

    /**
     * Get all in phpinfo() as string
     *
     * @return string
     */
    public function getAll(): string
    {
        return $this->get(INFO_ALL);
    }

    /**
     * Get general in phpinfo() as string
     *
     * @return string
     */
    public function getGeneral(): string
    {
        return $this->get(INFO_GENERAL);
    }

    /**
     * Get credits in phpinfo() as string
     *
     * @return string
     */
    public function getCredits(): string
    {
        return $this->get(INFO_CREDITS);
    }

    /**
     * Get configuration in phpinfo() as string
     *
     * @return string
     */
    public function getConfiguration(): string
    {
        return $this->get(INFO_CONFIGURATION);
    }

    /**
     * Get modules in phpinfo() as string
     *
     * @return string
     */
    public function getModules(): string
    {
        return $this->get(INFO_MODULES);
    }

    /**
     * Get environment in phpinfo() as string
     *
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->get(INFO_ENVIRONMENT);
    }

    /**
     * Get variables in phpinfo() as string
     *
     * @return string
     */
    public function getVariables(): string
    {
        return $this->get(INFO_VARIABLES);
    }

    /**
     * Get license in phpinfo() as string
     *
     * @return string
     */
    public function getLicense(): string
    {
        return $this->get(INFO_LICENSE);
    }

    /*----------------------------------------*
     * Flags
     *----------------------------------------*/

    /**
     * Valid flags
     *
     * @var array<int>
     */
    protected array $validFlags = [
        INFO_GENERAL,
        INFO_CREDITS,
        INFO_CONFIGURATION,
        INFO_MODULES,
        INFO_ENVIRONMENT,
        INFO_VARIABLES,
        INFO_LICENSE,
        INFO_ALL
    ];

    /**
     * Whether flags are valid
     *
     * @param int|null $flags
     * @return bool
     */
    protected function isValidFlags(int|null $flags): bool
    {
        if (is_null($flags)) false;

        return in_array($flags, $this->validFlags, true);
    }
}
