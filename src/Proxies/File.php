<?php

declare(strict_types=1);

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\FileManager;

/**
 * File Proxy
 *
 * @package Spark\Proxies
 *
 * @method static \Spark\Contracts\File\Pathinfo pathinfo()
 *
 * @method static \Spark\Contracts\File\Operator operator()
 *
 * @method static \Spark\Contracts\File\TextReader textReader()
 * @method static \Spark\Contracts\File\CsvReader csvReader()
 * @method static \Spark\Contracts\File\JsonReader jsonReader()
 *
 * @method static \Spark\Contracts\File\TextWriter textWriter()
 * @method static \Spark\Contracts\File\CsvWriter csvWriter()
 * @method static \Spark\Contracts\File\JsonWriter jsonWriter()
 *
 * @see \Spark\Proxies\Managers\FileManager
 */
class File extends MethodProxy
{
    /**
     * Proxy target
     *
     * @var string
     */
    protected string $proxyTarget = FileManager::class;
}
