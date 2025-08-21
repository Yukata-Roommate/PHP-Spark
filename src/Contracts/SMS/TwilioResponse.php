<?php

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
     * get is received success response
     *
     * @return bool
     */
    public function isSuccess(): bool;

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * get Twilio response
     *
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
     */
    public function response(): MessageInstance;

    /**
     * get Twilio response as array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * get sender
     *
     * @return string|null
     */
    public function sender(): string|null;

    /**
     * get recipient
     *
     * @return string|null
     */
    public function recipient(): string|null;

    /**
     * get body
     *
     * @return string|null
     */
    public function body(): string|null;

    /**
     * get status
     *
     * @return string
     */
    public function status(): string;

    /**
     * get errorCode
     *
     * @return int|null
     */
    public function errorCode(): int|null;

    /**
     * get errorMessage
     *
     * @return string|null
     */
    public function errorMessage(): string|null;

    /**
     * get sid
     *
     * @return string|null
     */
    public function sid(): string|null;

    /**
     * get accountSid
     *
     * @return string|null
     */
    public function accountSid(): string|null;

    /**
     * get apiVersion
     *
     * @return string|null
     */
    public function apiVersion(): string|null;

    /**
     * get dateCreated
     *
     * @return \DateTime|null
     */
    public function dateCreated(): \DateTime|null;

    /**
     * get dateCreated as string
     *
     * @param string $format
     * @return string|null
     */
    public function dateCreatedString(string $format = "Y-m-d H:i:s"): string|null;

    /**
     * get dateUpdated
     *
     * @return \DateTime|null
     */
    public function dateUpdated(): \DateTime|null;

    /**
     * get dateUpdated as string
     *
     * @param string $format
     * @return string|null
     */
    public function dateUpdatedString(string $format = "Y-m-d H:i:s"): string|null;

    /**
     * get dateSent
     *
     * @return \DateTime|null
     */
    public function dateSent(): \DateTime|null;

    /**
     * get dateSent as string
     *
     * @param string $format
     * @return string|null
     */
    public function dateSentString(string $format = "Y-m-d H:i:s"): string|null;

    /**
     * get price
     *
     * @return string|null
     */
    public function price(): string|null;

    /**
     * get price as float
     *
     * @return float|null
     */
    public function priceFloat(): float|null;

    /**
     * get priceUnit
     *
     * @return string|null
     */
    public function priceUnit(): string|null;

    /**
     * get priceUnit as float
     *
     * @return float|null
     */
    public function priceUnitFloat(): float|null;

    /**
     * get uri
     *
     * @return string|null
     */
    public function uri(): string|null;

    /**
     * get numSegments
     *
     * @return string|null
     */
    public function numSegments(): string|null;

    /**
     * get direction
     *
     * @return string
     */
    public function direction(): string;

    /**
     * get messagingServiceSid
     *
     * @return string|null
     */
    public function messagingServiceSid(): string|null;

    /**
     * get numMedia
     *
     * @return string|null
     */
    public function numMedia(): string|null;

    /**
     * get subresourceUris
     *
     * @return array<string, string>|null
     */
    public function subresourceUris(): array|null;
}
