<?php

declare(strict_types=1);

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\DBManager;

/**
 * DB Proxy
 *
 * @package Spark\Proxies
 *
 * @method static \Spark\Contracts\DB\MySQLDumper mysqlDumper()
 *
 * @see \Spark\Proxies\Managers\DBManager
 */
class DB extends MethodProxy
{
    /**
     * Proxy target
     *
     * @var string
     */
    protected string $proxyTarget = DBManager::class;
}
