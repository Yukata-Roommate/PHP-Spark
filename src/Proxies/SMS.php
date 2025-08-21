<?php

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\SMSManager;

/**
 * SMS Proxy
 *
 * @package Spark\Proxies
 *
 * @method static \Spark\Contracts\SMS\TwilioClient twilio()
 *
 * @see \Spark\Proxies\Managers\SMSManager
 */
class SMS extends MethodProxy
{
    /**
     * proxy target
     *
     * @var string
     */
    protected string $proxyTarget = SMSManager::class;
}
