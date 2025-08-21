<?php

namespace Spark\Proxies\Managers;

use Spark\Contracts\SMS\TwilioClient as TwilioClientContract;
use Spark\SMS\Twilio\TwilioClient;

/**
 * SMS Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class SMSManager
{
    /**
     * make twilio client
     *
     * @return \Spark\Contracts\SMS\TwilioClient
     */
    public function twilio(): TwilioClientContract
    {
        return new TwilioClient();
    }
}
