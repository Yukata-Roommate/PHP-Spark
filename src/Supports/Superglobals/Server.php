<?php

declare(strict_types=1);

namespace Spark\Supports\Superglobals;

use Spark\Foundation\Container\Reference;

/**
 * Server Reference
 *
 * @package Spark\Supports\Superglobals
 */
class Server extends Reference
{
    /*----------------------------------------*
     * Reference
     *----------------------------------------*/

    /**
     * Get reference
     *
     * @return array
     */
    protected function &reference(): array
    {
        return $_SERVER;
    }

    /*----------------------------------------*
     * Command Line
     *----------------------------------------*/

    /**
     * Get command line argument count
     *
     * @return int
     */
    public function argc(): int
    {
        return $this->int("argc");
    }

    /**
     * Get command line arguments
     *
     * @return array
     */
    public function argv(): array
    {
        return $this->array("argv");
    }

    /*----------------------------------------*
     * Auth
     *----------------------------------------*/

    /**
     * Get auth type
     *
     * @return string
     */
    public function authType(): string
    {
        return $this->string("AUTH_TYPE");
    }

    /**
     * Get auth user
     *
     * @return string
     */
    public function authUser(): string
    {
        return $this->string("PHP_AUTH_USER");
    }

    /**
     * Get auth password
     *
     * @return string
     */
    public function authPassword(): string
    {
        return $this->string("PHP_AUTH_PW");
    }

    /**
     * Get auth digest
     *
     * @return string
     */
    public function authDigest(): string
    {
        return $this->string("PHP_AUTH_DIGEST");
    }

    /*----------------------------------------*
     * Document
     *----------------------------------------*/

    /**
     * Get document root
     *
     * @return string
     */
    public function documentRoot(): string
    {
        return $this->string("DOCUMENT_ROOT");
    }

    /**
     * Get php self
     *
     * @return string
     */
    public function phpSelf(): string
    {
        return $this->string("PHP_SELF");
    }

    /*----------------------------------------*
     * Gateway
     *----------------------------------------*/

    /**
     * Get gateway interface
     *
     * @return string
     */
    public function gatewayInterface(): string
    {
        return $this->string("GATEWAY_INTERFACE");
    }

    /*----------------------------------------*
     * Https
     *----------------------------------------*/

    /**
     * Get https status
     *
     * @return string
     */
    public function https(): string
    {
        return $this->string("HTTPS");
    }

    /**
     * Whether https is enabled
     *
     * @return bool
     */
    public function isHttps(): bool
    {
        return $this->https() === "on" || $this->serverPort() === 443;
    }

    /**
     * Get http scheme
     *
     * @return string
     */
    public function httpScheme(): string
    {
        return $this->isHttps() ? "https" : "http";
    }

    /*----------------------------------------*
     * Path
     *----------------------------------------*/

    /**
     * Get path info
     *
     * @return string
     */
    public function pathInfo(): string
    {
        return $this->string("PATH_INFO");
    }

    /**
     * Get path translated
     *
     * @return string
     */
    public function pathTranslated(): string
    {
        return $this->string("PATH_TRANSLATED");
    }

    /**
     * Get original path info
     *
     * @return string
     */
    public function originalPathInfo(): string
    {
        return $this->string("ORIG_PATH_INFO");
    }

    /*----------------------------------------*
     * Query
     *----------------------------------------*/

    /**
     * Get query string
     *
     * @return string
     */
    public function queryString(): string
    {
        return $this->string("QUERY_STRING");
    }

    /**
     * Get query parameters
     *
     * @return array
     */
    public function queryParameters(): array
    {
        $queryString = $this->queryString();

        if ($queryString === "") return [];

        $params = [];

        parse_str($queryString, $params);

        return $params;
    }

    /*----------------------------------------*
     * Remote
     *----------------------------------------*/

    /**
     * Get remote address
     *
     * @return string
     */
    public function remoteAddress(): string
    {
        return $this->string("REMOTE_ADDR");
    }

    /**
     * Get remote host
     *
     * @return string
     */
    public function remoteHost(): string
    {
        return $this->string("REMOTE_HOST");
    }

    /**
     * Get remote port
     *
     * @return int
     */
    public function remotePort(): int
    {
        return $this->int("REMOTE_PORT");
    }

    /**
     * Get remote user
     *
     * @return string
     */
    public function remoteUser(): string
    {
        return $this->string("REMOTE_USER");
    }

    /**
     * Get redirect remote user
     *
     * @return string
     */
    public function redirectRemoteUser(): string
    {
        return $this->string("REDIRECT_REMOTE_USER");
    }

    /*----------------------------------------*
     * Request
     *----------------------------------------*/

    /**
     * Get request method
     *
     * @return string
     */
    public function requestMethod(): string
    {
        return $this->string("REQUEST_METHOD", "GET");
    }

    /**
     * Get request time
     *
     * @return int
     */
    public function requestTime(): int
    {
        return $this->int("REQUEST_TIME");
    }

    /**
     * Get request time float
     *
     * @return float
     */
    public function requestTimeFloat(): float
    {
        return $this->float("REQUEST_TIME_FLOAT");
    }

    /**
     * Get request uri
     *
     * @return string
     */
    public function requestUri(): string
    {
        return $this->string("REQUEST_URI");
    }

    /*----------------------------------------*
     * Script
     *----------------------------------------*/

    /**
     * Get script name
     *
     * @return string
     */
    public function scriptName(): string
    {
        return $this->string("SCRIPT_NAME");
    }

    /**
     * Get script filename
     *
     * @return string
     */
    public function scriptFilename(): string
    {
        return $this->string("SCRIPT_FILENAME");
    }

    /*----------------------------------------*
     * Server
     *----------------------------------------*/

    /**
     * Get server address
     *
     * @return string
     */
    public function serverAddress(): string
    {
        return $this->string("SERVER_ADDR");
    }

    /**
     * Get server admin
     *
     * @return string
     */
    public function serverAdmin(): string
    {
        return $this->string("SERVER_ADMIN");
    }

    /**
     * Get server name
     *
     * @return string
     */
    public function serverName(): string
    {
        return $this->string("SERVER_NAME", "localhost");
    }

    /**
     * Get server port
     *
     * @return int
     */
    public function serverPort(): int
    {
        return $this->int("SERVER_PORT", 80);
    }

    /**
     * Get server protocol
     *
     * @return string
     */
    public function serverProtocol(): string
    {
        return $this->string("SERVER_PROTOCOL");
    }

    /**
     * Get server signature
     *
     * @return string
     */
    public function serverSignature(): string
    {
        return $this->string("SERVER_SIGNATURE");
    }

    /**
     * Get server software
     *
     * @return string
     */
    public function serverSoftware(): string
    {
        return $this->string("SERVER_SOFTWARE");
    }

    /*----------------------------------------*
     * HTTP
     *----------------------------------------*/

    /**
     * Whether is http key
     *
     * @param string $key
     * @return bool
     */
    protected function isHttpKey(string $key): bool
    {
        return str_starts_with($key, "HTTP_");
    }

    /**
     * Get http key
     *
     * @param string $key
     * @return string
     */
    protected function httpKey(string $key): string
    {
        if (!$this->isHttpKey($key)) $key = "HTTP_$key";

        $key = strtoupper(str_replace("-", "_", $key));

        return $key;
    }

    /**
     * Get http headers
     *
     * @return array
     */
    public function headers(): array
    {
        $headers = [];

        foreach ($this->reference() as $key => $value) {
            if (!$this->isHttpKey($key)) continue;

            $headerKey = str_replace("_", "-", substr($key, 5));
            $headers[$headerKey] = $value;
        }

        return $headers;
    }

    /**
     * Get http header
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    public function header(string $key, string $default = ""): string
    {
        return $this->string($this->httpKey($key), $default);
    }

    /**
     * Get http host
     *
     * @return string
     */
    public function httpHost(): string
    {
        return $this->header("HOST", $this->serverName());
    }

    /**
     * Get http user agent
     *
     * @return string
     */
    public function userAgent(): string
    {
        return $this->header("USER_AGENT");
    }

    /**
     * Get http cache control
     *
     * @return string
     */
    public function cacheControl(): string
    {
        return $this->header("CACHE_CONTROL");
    }

    /**
     * Get http accept
     *
     * @return string
     */
    public function accept(): string
    {
        return $this->header("ACCEPT");
    }

    /**
     * Whether request is ajax
     *
     * @return bool
     */
    public function isAjax(): bool
    {
        return $this->header("X_REQUESTED_WITH") === "XMLHttpRequest";
    }

    /*----------------------------------------*
     * Other
     *----------------------------------------*/

    /**
     * Get client ip address
     *
     * @return string
     */
    public function clientIp(): string
    {
        $ipKeys = [
            "HTTP_CLIENT_IP",
            "HTTP_X_FORWARDED_FOR",
            "HTTP_X_FORWARDED",
            "HTTP_X_CLUSTER_CLIENT_IP",
            "HTTP_FORWARDED_FOR",
            "HTTP_FORWARDED",
        ];

        foreach ($ipKeys as $key) {
            if (!$this->has($key)) continue;

            $ip = $this->string($key);

            if (filter_var($ip, FILTER_VALIDATE_IP)) return $ip;
        }

        return $this->remoteAddress();
    }

    /**
     * Get request url
     *
     * @return string
     */
    public function requestUrl(): string
    {
        $scheme = $this->httpScheme();
        $host   = $this->httpHost();
        $uri    = $this->requestUri();

        return "{$scheme}://{$host}{$uri}";
    }
}
