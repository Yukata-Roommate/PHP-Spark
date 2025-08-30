<?php

declare(strict_types=1);

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\SingletonManager;

use Spark\Contracts\Timer\Timer as TimerContract;
use Spark\Timer\Timer;

use Spark\Contracts\Timer\SplitTimer as SplitTimerContract;
use Spark\Timer\SplitTimer;

use Spark\Contracts\Timer\LapTimer as LapTimerContract;
use Spark\Timer\LapTimer;

/**
 * Timer Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class TimerManager extends SingletonManager
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
        $this->addFactory(TimerContract::class, fn() => new Timer());
        $this->addFactory(SplitTimerContract::class, fn() => new SplitTimer());
        $this->addFactory(LapTimerContract::class, fn() => new LapTimer());
    }

    /**
     * Get singleton timer
     *
     * @return \Spark\Contracts\Timer\Timer
     */
    protected function singletonTimer(): TimerContract
    {
        return $this->singleton(TimerContract::class);
    }

    /**
     * Get singleton split timer
     *
     * @return \Spark\Contracts\Timer\SplitTimer
     */
    protected function singletonSplitTimer(): SplitTimerContract
    {
        return $this->singleton(SplitTimerContract::class);
    }

    /**
     * Get singleton lap timer
     *
     * @return \Spark\Contracts\Timer\LapTimer
     */
    protected function singletonLapTimer(): LapTimerContract
    {
        return $this->singleton(LapTimerContract::class);
    }

    /*----------------------------------------*
     * Accessor
     *----------------------------------------*/

    /**
     * Make timer
     *
     * @return \Spark\Contracts\Timer\Timer
     */
    public function make(): TimerContract
    {
        return $this->singletonTimer()->reset();
    }

    /**
     * Start timer
     *
     * @return \Spark\Contracts\Timer\Timer
     */
    public function start(): TimerContract
    {
        return $this->make()->start();
    }

    /**
     * Make split timer
     *
     * @return \Spark\Contracts\Timer\SplitTimer
     */
    public function split(): SplitTimerContract
    {
        return $this->singletonSplitTimer()->reset();
    }

    /**
     * Start split timer
     *
     * @return \Spark\Contracts\Timer\SplitTimer
     */
    public function startSplit(): SplitTimerContract
    {
        return $this->split()->start();
    }

    /**
     * Make lap timer
     *
     * @return \Spark\Contracts\Timer\LapTimer
     */
    public function lap(): LapTimerContract
    {
        return $this->singletonLapTimer()->reset();
    }

    /**
     * Start lap timer
     *
     * @return \Spark\Contracts\Timer\LapTimer
     */
    public function startLap(): LapTimerContract
    {
        return $this->lap()->start();
    }
}
