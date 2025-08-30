<?php

declare(strict_types=1);

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\TimerManager;

/**
 * Timer Proxy
 *
 * @package Spark\Proxies
 *
 * @method static \Spark\Contracts\Timer\Timer make()
 * @method static \Spark\Contracts\Timer\Timer start()
 *
 * @method static \Spark\Contracts\Timer\SplitTimer split()
 * @method static \Spark\Contracts\Timer\SplitTimer startSplit()
 *
 * @method static \Spark\Contracts\Timer\LapTimer lap()
 * @method static \Spark\Contracts\Timer\LapTimer startLap()
 *
 * @see \Spark\Proxies\Managers\TimerManager
 */
class Timer extends MethodProxy
{
    /**
     * Proxy target
     *
     * @var string
     */
    protected string $proxyTarget = TimerManager::class;
}
