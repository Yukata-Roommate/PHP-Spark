<?php

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
     * init manager
     *
     * @return void
     */
    protected function init(): void {}

    /*----------------------------------------*
     * Show
     *----------------------------------------*/

    /**
     * show phpinfo()
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
     * show all in phpinfo()
     *
     * @return bool
     */
    public function showAll(): bool
    {
        return $this->show(INFO_ALL);
    }

    /**
     * show general in phpinfo()
     *
     * @return bool
     */
    public function showGeneral(): bool
    {
        return $this->show(INFO_GENERAL);
    }

    /**
     * show credits in phpinfo()
     *
     * @return bool
     */
    public function showCredits(): bool
    {
        return $this->show(INFO_CREDITS);
    }

    /**
     * show configuration in phpinfo()
     *
     * @return bool
     */
    public function showConfiguration(): bool
    {
        return $this->show(INFO_CONFIGURATION);
    }

    /**
     * show modules in phpinfo()
     *
     * @return bool
     */
    public function showModules(): bool
    {
        return $this->show(INFO_MODULES);
    }

    /**
     * show environment in phpinfo()
     *
     * @return bool
     */
    public function showEnvironment(): bool
    {
        return $this->show(INFO_ENVIRONMENT);
    }

    /**
     * show variables in phpinfo()
     *
     * @return bool
     */
    public function showVariables(): bool
    {
        return $this->show(INFO_VARIABLES);
    }

    /**
     * show license in phpinfo()
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
     * get phpinfo() as string
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
     * get all in phpinfo() as string
     *
     * @return string
     */
    public function getAll(): string
    {
        return $this->get(INFO_ALL);
    }

    /**
     * get general in phpinfo() as string
     *
     * @return string
     */
    public function getGeneral(): string
    {
        return $this->get(INFO_GENERAL);
    }

    /**
     * get credits in phpinfo() as string
     *
     * @return string
     */
    public function getCredits(): string
    {
        return $this->get(INFO_CREDITS);
    }

    /**
     * get configuration in phpinfo() as string
     *
     * @return string
     */
    public function getConfiguration(): string
    {
        return $this->get(INFO_CONFIGURATION);
    }

    /**
     * get modules in phpinfo() as string
     *
     * @return string
     */
    public function getModules(): string
    {
        return $this->get(INFO_MODULES);
    }

    /**
     * get environment in phpinfo() as string
     *
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->get(INFO_ENVIRONMENT);
    }

    /**
     * get variables in phpinfo() as string
     *
     * @return string
     */
    public function getVariables(): string
    {
        return $this->get(INFO_VARIABLES);
    }

    /**
     * get license in phpinfo() as string
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
     * valid flags
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
     * whether flags are valid
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
