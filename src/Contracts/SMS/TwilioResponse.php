<?php

declare(strict_types=1);

namespace Spark\Contracts\SMS;

use Twilio\Rest\Api\V2010\Account\MessageInstance;

/**
 * SMS Twilio Response Contract
 *
 * @package Spark\Contracts\SMS
 */
interface TwilioResponse
{
    /*----------------------------------------*
     * Result
     *----------------------------------------*/

    /**
     * Get is received success response
     *
     * @return bool
     */
    public function isSuccess(): bool;

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * Get Twilio response
     *
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
     */
    public function response(): MessageInstance;

    /**
     * Get Twilio response as array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * Get sender
     *
     * @return string|null
     */
    public function sender(): string|null;

    /**
     * Get recipient
     *
     * @return string|null
     */
    public function recipient(): string|null;

    /**
     * Get body
     *
     * @return string|null
     */
    public function body(): string|null;

    /**
     * Get status
     *
     * @return string
     */
    public function status(): string;

    /**
     * Get errorCode
     *
     * @return int|null
     */
    public function errorCode(): int|null;

    /**
     * Get errorMessage
     *
     * @return string|null
     */
    public function errorMessage(): string|null;

    /**
     * Get sid
     *
     * @return string|null
     */
    public function sid(): string|null;

    /**
     * Get accountSid
     *
     * @return string|null
     */
    public function accountSid(): string|null;

    /**
     * Get apiVersion
     *
     * @return string|null
     */
    public function apiVersion(): string|null;

    /**
     * Get dateCreated
     *
     * @return \DateTime|null
     */
    public function dateCreated(): \DateTime|null;

    /**
     * Get dateCreated as string
     *
     * @param string $format
     * @return string|null
     */
    public function dateCreatedString(string $format = "Y-m-d H:i:s"): string|null;

    /**
     * Get dateUpdated
     *
     * @return \DateTime|null
     */
    public function dateUpdated(): \DateTime|null;

    /**
     * Get dateUpdated as string
     *
     * @param string $format
     * @return string|null
     */
    public function dateUpdatedString(string $format = "Y-m-d H:i:s"): string|null;

    /**
     * Get dateSent
     *
     * @return \DateTime|null
     */
    public function dateSent(): \DateTime|null;

    /**
     * Get dateSent as string
     *
     * @param string $format
     * @return string|null
     */
    public function dateSentString(string $format = "Y-m-d H:i:s"): string|null;

    /**
     * Get price
     *
     * @return string|null
     */
    public function price(): string|null;

    /**
     * Get price as float
     *
     * @return float|null
     */
    public function priceFloat(): float|null;

    /**
     * Get priceUnit
     *
     * @return string|null
     */
    public function priceUnit(): string|null;

    /**
     * Get priceUnit as float
     *
     * @return float|null
     */
    public function priceUnitFloat(): float|null;

    /**
     * Get uri
     *
     * @return string|null
     */
    public function uri(): string|null;

    /**
     * Get numSegments
     *
     * @return string|null
     */
    public function numSegments(): string|null;

    /**
     * Get direction
     *
     * @return string
     */
    public function direction(): string;

    /**
     * Get messagingServiceSid
     *
     * @return string|null
     */
    public function messagingServiceSid(): string|null;

    /**
     * Get numMedia
     *
     * @return string|null
     */
    public function numMedia(): string|null;

    /**
     * Get subresourceUris
     *
     * @return array<string, string>|null
     */
    public function subresourceUris(): array|null;
}
