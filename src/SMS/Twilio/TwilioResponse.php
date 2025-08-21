<?php

namespace Spark\SMS\Twilio;

use Spark\Contracts\SMS\TwilioResponse as TwilioResponseContract;

use Twilio\Rest\Api\V2010\Account\MessageInstance;

/**
 * SMS Twilio Response
 *
 * @package Spark\SMS\Twilio
 */
class TwilioResponse implements TwilioResponseContract
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Twilio response
     *
     * @var \Twilio\Rest\Api\V2010\Account\MessageInstance
     */
    protected MessageInstance $response;

    /**
     * constructor
     *
     * @param \Twilio\Rest\Api\V2010\Account\MessageInstance $response
     */
    public function __construct(MessageInstance $response)
    {
        $this->response = $response;
    }

    /*----------------------------------------*
     * Result
     *----------------------------------------*/

    /**
     * get is received success response
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return is_null($this->errorCode()) && is_null($this->errorMessage());
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * get Twilio response
     *
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
     */
    public function response(): MessageInstance
    {
        return $this->response;
    }

    /**
     * get Twilio response as array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->response->toArray();
    }

    /**
     * get sender
     *
     * @return string|null
     */
    public function sender(): string|null
    {
        return $this->response->from;
    }

    /**
     * get recipient
     *
     * @return string|null
     */
    public function recipient(): string|null
    {
        return $this->response->to;
    }

    /**
     * get body
     *
     * @return string|null
     */
    public function body(): string|null
    {
        return $this->response->body;
    }

    /**
     * get status
     *
     * @return string
     */
    public function status(): string
    {
        return $this->response->status;
    }

    /**
     * get errorCode
     *
     * @return int|null
     */
    public function errorCode(): int|null
    {
        return $this->response->errorCode;
    }

    /**
     * get errorMessage
     *
     * @return string|null
     */
    public function errorMessage(): string|null
    {
        return $this->response->errorMessage;
    }

    /**
     * get sid
     *
     * @return string|null
     */
    public function sid(): string|null
    {
        return $this->response->sid;
    }

    /**
     * get accountSid
     *
     * @return string|null
     */
    public function accountSid(): string|null
    {
        return $this->response->accountSid;
    }

    /**
     * get apiVersion
     *
     * @return string|null
     */
    public function apiVersion(): string|null
    {
        return $this->response->apiVersion;
    }

    /**
     * get dateCreated
     *
     * @return \DateTime|null
     */
    public function dateCreated(): \DateTime|null
    {
        return $this->response->dateCreated;
    }

    /**
     * get dateCreated as string
     *
     * @param string $format
     * @return string|null
     */
    public function dateCreatedString(string $format = "Y-m-d H:i:s"): string|null
    {
        $dateCreated = $this->dateCreated();

        return is_null($dateCreated) ? null : $dateCreated->format($format);
    }

    /**
     * get dateUpdated
     *
     * @return \DateTime|null
     */
    public function dateUpdated(): \DateTime|null
    {
        return $this->response->dateUpdated;
    }

    /**
     * get dateUpdated as string
     *
     * @param string $format
     * @return string|null
     */
    public function dateUpdatedString(string $format = "Y-m-d H:i:s"): string|null
    {
        $dateUpdated = $this->dateUpdated();

        return is_null($dateUpdated) ? null : $dateUpdated->format($format);
    }

    /**
     * get dateSent
     *
     * @return \DateTime|null
     */
    public function dateSent(): \DateTime|null
    {
        return $this->response->dateSent;
    }

    /**
     * get dateSent as string
     *
     * @param string $format
     * @return string|null
     */
    public function dateSentString(string $format = "Y-m-d H:i:s"): string|null
    {
        $dateSent = $this->dateSent();

        return is_null($dateSent) ? null : $dateSent->format($format);
    }

    /**
     * get price
     *
     * @return string|null
     */
    public function price(): string|null
    {
        return $this->response->price;
    }

    /**
     * get price as float
     *
     * @return float|null
     */
    public function priceFloat(): float|null
    {
        $price = $this->price();

        return is_null($price) ? null : (float) $price;
    }

    /**
     * get priceUnit
     *
     * @return string|null
     */
    public function priceUnit(): string|null
    {
        return $this->response->priceUnit;
    }

    /**
     * get priceUnit as float
     *
     * @return float|null
     */
    public function priceUnitFloat(): float|null
    {
        $priceUnit = $this->priceUnit();

        return is_null($priceUnit) ? null : (float) $priceUnit;
    }

    /**
     * get uri
     *
     * @return string|null
     */
    public function uri(): string|null
    {
        return $this->response->uri;
    }

    /**
     * get numSegments
     *
     * @return string|null
     */
    public function numSegments(): string|null
    {
        return $this->response->numSegments;
    }

    /**
     * get direction
     *
     * @return string
     */
    public function direction(): string
    {
        return $this->response->direction;
    }

    /**
     * get messagingServiceSid
     *
     * @return string|null
     */
    public function messagingServiceSid(): string|null
    {
        return $this->response->messagingServiceSid;
    }

    /**
     * get numMedia
     *
     * @return string|null
     */
    public function numMedia(): string|null
    {
        return $this->response->numMedia;
    }

    /**
     * get subresourceUris
     *
     * @return array<string, string>|null
     */
    public function subresourceUris(): array|null
    {
        return $this->response->subresourceUris;
    }
}
