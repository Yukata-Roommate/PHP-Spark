<?php

declare(strict_types=1);

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\PHPInfoManager;

/**
 * PHPInfo Proxy
 *
 * @package Spark\Proxies
 *
 * @method static bool show(int|null $flags = null)
 * @method static bool showAll()
 * @method static bool showGeneral()
 * @method static bool showCredits()
 * @method static bool showConfiguration()
 * @method static bool showModules()
 * @method static bool showEnvironment()
 * @method static bool showVariables()
 * @method static bool showLicense()
 *
 * @method static string get(int|null $flags = null)
 * @method static string getAll()
 * @method static string getGeneral()
 * @method static string getCredits()
 * @method static string getConfiguration()
 * @method static string getModules()
 * @method static string getEnvironment()
 * @method static string getVariables()
 * @method static string getLicense()
 *
 * @see \Spark\Proxies\Managers\PHPInfoManager
 */
class PHPInfo extends MethodProxy
{
    /**
     * Proxy target
     *
     * @var string
     */
    protected string $proxyTarget = PHPInfoManager::class;
}
