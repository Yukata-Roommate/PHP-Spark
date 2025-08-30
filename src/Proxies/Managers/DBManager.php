<?php

declare(strict_types=1);

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\ProxyManager;

use Spark\Contracts\DB\MySQLDumper as MySQLDumperContract;
use Spark\DB\MySQLDumper;

/**
 * DB Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class DBManager extends ProxyManager
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
     * Accessor
     *----------------------------------------*/

    /**
     * Get mysql dumper
     *
     * @return \Spark\Contracts\DB\MySQLDumper
     */
    public function mysqlDumper(): MySQLDumperContract
    {
        return new MySQLDumper();
    }
}
