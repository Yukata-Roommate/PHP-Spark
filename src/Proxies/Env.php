<?php

declare(strict_types=1);

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\EnvManager;

/**
 * Env Proxy
 *
 * @package Spark\Proxies
 *
 * @method static \Spark\Supports\Env\Loader loader()
 *
 * @method static void flush()
 * @method static string string(string $name, string|null $default = null)
 * @method static string|null nullableString(string $name)
 * @method static int int(string $name, int|null $default = null)
 * @method static int|null nullableInt(string $name)
 * @method static float float(string $name, float|null $default = null)
 * @method static float|null nullableFloat(string $name)
 * @method static bool bool(string $name, bool|null $default = null)
 * @method static bool|null nullableBool(string $name)
 * @method static array array(string $name, array|null $default = null)
 * @method static array|null nullableArray(string $name)
 * @method static object object(string $name, object|null $default = null)
 * @method static object|null nullableObject(string $name)
 * @method static \UnitEnum enum(string $name, string $enumClass, \UnitEnum|null $default = null)
 * @method static \UnitEnum|null nullableEnum(string $name, string $enumClass)
 *
 * @see \Spark\Proxies\Managers\EnvManager
 */
class Env extends MethodProxy
{
    /**
     * Proxy target
     *
     * @var string
     */
    protected string $proxyTarget = EnvManager::class;
}
