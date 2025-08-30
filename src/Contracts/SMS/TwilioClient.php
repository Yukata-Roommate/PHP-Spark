<?php

declare(strict_types=1);

namespace Spark\Contracts\SMS;

use Spark\Contracts\SMS\TwilioResponse;

/**
 * SMS Twilio Client Contract
 *
 * @package Spark\Contracts\SMS
 */
interface TwilioClient
{
    /*----------------------------------------*
     * Sending
     *----------------------------------------*/

    /**
     * Send SMS
     *
     * @return \Spark\Contracts\SMS\TwilioResponse
     */
    public function send(): TwilioResponse;

    /*----------------------------------------*
     * Address
     *----------------------------------------*/

    /**
     * Get recipient
     *
     * @return string|null
     */
    public function recipient(): string|null;

    /**
     * Set recipient
     *
     * @param string $recipient
     * @return static
     */
    public function setRecipient(string $recipient): static;

    /**
     * Get sender
     *
     * @return string|null
     */
    public function sender(): string|null;

    /**
     * Set sender
     *
     * @param string $sender
     * @return static
     */
    public function setSender(string $sender): static;

    /*----------------------------------------*
     * Body
     *----------------------------------------*/

    /**
     * Get body
     *
     * @return string
     */
    public function body(): string;

    /**
     * Set body array
     *
     * @param array<string> $body
     * @return static
     */
    public function setBodyArray(array $body): static;

    /**
     * Set body
     *
     * @param string $body
     * @return static
     */
    public function setBody(string $body): static;

    /**
     * Add body
     *
     * @param string $body
     * @return static
     */
    public function addBody(string $body): static;

    /**
     * Clear body
     *
     * @return static
     */
    public function clearBody(): static;

    /*----------------------------------------*
     * Auth
     *----------------------------------------*/

    /**
     * Set account sid
     *
     * @return string|null
     */
    public function accountSid(): string|null;

    /**
     * Set account sid
     *
     * @param string $accountSid
     * @return static
     */
    public function setAccountSid(string $accountSid): static;

    /**
     * Get auth token
     *
     * @return string|null
     */
    public function authToken(): string|null;

    /**
     * Set auth token
     *
     * @param string $authToken
     * @return static
     */
    public function setAuthToken(string $authToken): static;

    /*----------------------------------------*
     * Status Callback
     *----------------------------------------*/

    /**
     * Get callback url
     *
     * @return string|null
     */
    public function statusCallback(): string|null;

    /**
     * Set callback url
     *
     * @param string $statusCallback
     * @return static
     */
    public function setStatusCallback(string $statusCallback): static;
}
