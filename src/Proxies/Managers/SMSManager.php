<?php

declare(strict_types=1);

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\ProxyManager;

use Spark\Contracts\SMS\TwilioClient as TwilioClientContract;
use Spark\SMS\Twilio\TwilioClient;

/**
 * SMS Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class SMSManager extends ProxyManager
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
     * Make twilio client
     *
     * @return \Spark\Contracts\SMS\TwilioClient
     */
    public function twilio(): TwilioClientContract
    {
        return new TwilioClient();
    }
}
