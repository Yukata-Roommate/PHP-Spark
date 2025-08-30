<?php

declare(strict_types=1);

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\ProxyManager;

use Spark\Contracts\File\Pathinfo as PathinfoContract;
use Spark\File\Pathinfo;

use Spark\Contracts\File\Operator as OperatorContract;
use Spark\File\Operator;

use Spark\Contracts\File\TextReader as TextReaderContract;
use Spark\Contracts\File\CsvReader as CsvReaderContract;
use Spark\Contracts\File\JsonReader as JsonReaderContract;
use Spark\File\TextReader;
use Spark\File\CsvReader;
use Spark\File\JsonReader;

use Spark\Contracts\File\TextWriter as TextWriterContract;
use Spark\Contracts\File\CsvWriter as CsvWriterContract;
use Spark\Contracts\File\JsonWriter as JsonWriterContract;
use Spark\File\TextWriter;
use Spark\File\CsvWriter;
use Spark\File\JsonWriter;

/**
 * File Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class FileManager extends ProxyManager
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
     * Get pathinfo
     *
     * @return \Spark\Contracts\File\Pathinfo
     */
    public function pathinfo(): PathinfoContract
    {
        return new Pathinfo();
    }

    /**
     * Get file operator
     *
     * @return \Spark\Contracts\File\Operator
     */
    public function operator(): OperatorContract
    {
        return new Operator();
    }

    /**
     * Get text reader
     *
     * @return \Spark\Contracts\File\TextReader
     */
    public function textReader(): TextReaderContract
    {
        return new TextReader();
    }

    /**
     * Get csv reader
     *
     * @return \Spark\Contracts\File\CsvReader
     */
    public function csvReader(): CsvReaderContract
    {
        return new CsvReader();
    }

    /**
     * Get json reader
     *
     * @return \Spark\Contracts\File\JsonReader
     */
    public function jsonReader(): JsonReaderContract
    {
        return new JsonReader();
    }

    /**
     * Get text writer
     *
     * @return \Spark\Contracts\File\TextWriter
     */
    public function textWriter(): TextWriterContract
    {
        return new TextWriter();
    }

    /**
     * Get csv writer
     *
     * @return \Spark\Contracts\File\CsvWriter
     */
    public function csvWriter(): CsvWriterContract
    {
        return new CsvWriter();
    }

    /**
     * Get json writer
     *
     * @return \Spark\Contracts\File\JsonWriter
     */
    public function jsonWriter(): JsonWriterContract
    {
        return new JsonWriter();
    }
}
