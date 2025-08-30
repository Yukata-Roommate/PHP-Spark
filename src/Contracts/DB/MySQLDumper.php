<?php

declare(strict_types=1);

namespace Spark\Contracts\DB;

use Spark\Contracts\DB\Dumper;

/**
 * DB MySQL Dumper Contract
 *
 * @package Spark\Contracts\DB
 *
 * @method static bindAddress(string $ipAddress)
 * @method static compress()
 * @method static compressionAlgorithms(string $algorithm)
 * @method static defaultAuth(string $plugin)
 * @method static enableCleartextPlugin()
 * @method static getServerPublicKey()
 * @method static host(string $host)
 * @method static loginPath(string $path)
 * @method static password(string $password)
 * @method static pipe()
 * @method static pluginDir(string $directory)
 * @method static port(int $port)
 * @method static protocol(string $protocol)
 * @method static serverPublicKeyPath(string $path)
 * @method static socket(string $path)
 * @method static ssl()
 * @method static sslFipsMode(string $mode)
 * @method static tlsCiphersuites(string $ciphersuites)
 * @method static tlsVersion(string $version)
 * @method static user(string $user)
 * @method static zstdCompressionLevel(string $level)
 *
 * @method static defaultsExtraFile(string $file)
 * @method static defaultsFile(string $file)
 * @method static defaultsGroupSuffix(string $suffix)
 * @method static noDefaults()
 * @method static printDefaults()
 *
 * @method static addDropDatabase()
 * @method static addDropTable()
 * @method static addDropTrigger()
 * @method static allTablespaces()
 * @method static noCreateDb()
 * @method static noCreateInfo()
 * @method static noTablespaces()
 * @method static replace()
 *
 * @method static allowKeywords()
 * @method static comments()
 * @method static debug(string $option)
 * @method static debugCheck()
 * @method static debugInfo()
 * @method static dumpDate()
 * @method static force()
 * @method static logError(string $file)
 * @method static skipComments()
 * @method static verbose()
 *
 * @method static help()
 * @method static version()
 *
 * @method static characterSetsDir(string $directory)
 * @method static defaultCharacterSet(string $charset)
 * @method static noSetNames()
 * @method static setCharset()
 *
 * @method static applySlaveStatements()
 * @method static deleteMasterLogs()
 * @method static dumpSlave(string $value)
 * @method static includeMasterHostPort()
 * @method static masterData(string $value)
 * @method static setGtidPurged(string $value)
 *
 * @method static compact()
 * @method static compatible(string $name)
 * @method static completeInsert()
 * @method static createOptions()
 * @method static fieldsTerminatedBy(string $value)
 * @method static fieldsEnclosedBy(string $value)
 * @method static fieldsOptionallyEnclosedBy(string $value)
 * @method static fieldsEscapedBy(string $value)
 * @method static hexBlob()
 * @method static linesTerminatedBy(string $value)
 * @method static quoteNames()
 * @method static resultFile(string $file)
 * @method static showCreateSkipSecondaryEngine(string $value)
 * @method static tab(string $value)
 * @method static tzUtc()
 * @method static xml()
 *
 * @method static events()
 * @method static ignoreError(array $errors)
 * @method static ignoreTable(string $table)
 * @method static noData()
 * @method static routines()
 * @method static tables()
 * @method static triggers()
 * @method static where(string $condition)
 *
 * @method static columnStatistics()
 * @method static disableKeys()
 * @method static extendedInsert()
 * @method static insertIgnore()
 * @method static maxAllowedPacket(string $value)
 * @method static netBufferLength(string $value)
 * @method static networkTimeout()
 * @method static opt()
 * @method static quick()
 * @method static skipOpt()
 *
 * @method static addLocks()
 * @method static flushLogs()
 * @method static flushPrivileges()
 * @method static lockAllTables()
 * @method static lockTables()
 * @method static noAutocommit()
 * @method static orderByPrimary()
 * @method static sharedMemoryBaseName(string $name)
 * @method static singleTransaction()
 */
interface MySQLDumper extends Dumper
{
    /*----------------------------------------*
     * Database
     *----------------------------------------*/

    /**
     * Check if all databases
     *
     * @return bool
     */
    public function allDatabases(): bool;

    /**
     * Set all databases
     *
     * @param bool $allDatabases
     * @return static
     */
    public function setAllDatabases(bool $allDatabases = true): static;

    /**
     * Get database names
     *
     * @return array<string>
     */
    public function databases(): array;

    /**
     * Set database names
     *
     * @param string|array<string> $database
     * @return static
     */
    public function setDatabases(string|array $database): static;

    /**
     * Get table names
     *
     * @return array<string>
     */
    public function tables(): array;

    /**
     * Set table names
     *
     * @param array<string> $tables
     * @return static
     */
    public function setTables(array $tables): static;

    /*----------------------------------------*
     * Option
     *----------------------------------------*/

    /**
     * Get options
     *
     * @return array<string>
     */
    public function options(): array;

    /**
     * Get option string
     *
     * @return string
     */
    public function optionString(): string;

    /**
     * Set options
     *
     * @param array<string> $options
     * @return static
     */
    public function setOptions(array $options): static;

    /**
     * Add option
     *
     * @param string $name
     * @param string|null $value
     * @return static
     */
    public function addOption(string $name, string|null $value = null): static;
}
