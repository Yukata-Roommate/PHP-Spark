<?php

declare(strict_types=1);

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\SingletonManager;

use Spark\Contracts\Console\Application as ApplicationContract;
use Spark\Console\Application;

use Spark\Contracts\Console\Command;

/**
 * Console Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class ConsoleManager extends SingletonManager
{
    /*----------------------------------------*
     * Singleton
     *----------------------------------------*/

    /**
     * Init singletons
     *
     * @return void
     */
    protected function initSingletons(): void
    {
        $this->addFactory(ApplicationContract::class, fn() => new Application());
    }

    /*----------------------------------------*
     * Accessor
     *----------------------------------------*/

    /**
     * Make application
     *
     * @return \Spark\Contracts\Console\Application
     */
    public function application(): ApplicationContract
    {
        return new Application();
    }

    /*----------------------------------------*
     * Command
     *----------------------------------------*/

    /**
     * Run command
     *
     * @param \Spark\Contracts\Console\Command|string $command
     * @param array<string|int, string|int> $argv
     * @return void
     */
    public function run(Command|string $command, array $argv): void
    {
        if (is_string($command)) $command = new $command();

        if (!$command instanceof Command) throw new \InvalidArgumentException("Command must be instance of " . Command::class);

        $command->run($argv);
    }
}
