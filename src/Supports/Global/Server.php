<?php

namespace Spark\Supports\Global;

use Spark\Foundation\Entity\Reference;

/**
 * Server Reference
 *
 * @package Spark\Supports\Global
 */
class Server extends Reference
{
    /*----------------------------------------*
     * Reference
     *----------------------------------------*/

    /**
     * get reference
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
     * get command line argument count
     *
     * @return int
     */
    public function argc(): int
    {
        return $this->int("argc");
    }

    /**
     * get command line arguments
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
     * get auth type
     *
     * @return string
     */
    public function authType(): string
    {
        return $this->string("AUTH_TYPE");
    }

    /**
     * get auth user
     *
     * @return string
     */
    public function authUser(): string
    {
        return $this->string("PHP_AUTH_USER");
    }

    /**
     * get auth password
     *
     * @return string
     */
    public function authPassword(): string
    {
        return $this->string("PHP_AUTH_PW");
    }

    /**
     * get auth digest
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
     * get document root
     *
     * @return string
     */
    public function documentRoot(): string
    {
        return $this->string("DOCUMENT_ROOT");
    }

    /**
     * get php self
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
     * get gateway interface
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
     * get https status
     *
     * @return string
     */
    public function https(): string
    {
        return $this->string("HTTPS");
    }

    /**
     * whether https is enabled
     *
     * @return bool
     */
    public function isHttps(): bool
    {
        return $this->https() === "on" || $this->serverPort() === 443;
    }

    /**
     * get http scheme
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
     * get path info
     *
     * @return string
     */
    public function pathInfo(): string
    {
        return $this->string("PATH_INFO");
    }

    /**
     * get path translated
     *
     * @return string
     */
    public function pathTranslated(): string
    {
        return $this->string("PATH_TRANSLATED");
    }

    /**
     * get original path info
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
     * get query string
     *
     * @return string
     */
    public function queryString(): string
    {
        return $this->string("QUERY_STRING");
    }

    /**
     * get query parameters
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
     * get remote address
     *
     * @return string
     */
    public function remoteAddress(): string
    {
        return $this->string("REMOTE_ADDR");
    }

    /**
     * get remote host
     *
     * @return string
     */
    public function remoteHost(): string
    {
        return $this->string("REMOTE_HOST");
    }

    /**
     * get remote port
     *
     * @return int
     */
    public function remotePort(): int
    {
        return $this->int("REMOTE_PORT");
    }

    /**
     * get remote user
     *
     * @return string
     */
    public function remoteUser(): string
    {
        return $this->string("REMOTE_USER");
    }

    /**
     * get redirect remote user
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
     * get request method
     *
     * @return string
     */
    public function requestMethod(): string
    {
        return $this->string("REQUEST_METHOD", "GET");
    }

    /**
     * get request time
     *
     * @return int
     */
    public function requestTime(): int
    {
        return $this->int("REQUEST_TIME");
    }

    /**
     * get request time float
     *
     * @return float
     */
    public function requestTimeFloat(): float
    {
        return $this->float("REQUEST_TIME_FLOAT");
    }

    /**
     * get request uri
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
     * get script name
     *
     * @return string
     */
    public function scriptName(): string
    {
        return $this->string("SCRIPT_NAME");
    }

    /**
     * get script filename
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
     * get server address
     *
     * @return string
     */
    public function serverAddress(): string
    {
        return $this->string("SERVER_ADDR");
    }

    /**
     * get server admin
     *
     * @return string
     */
    public function serverAdmin(): string
    {
        return $this->string("SERVER_ADMIN");
    }

    /**
     * get server name
     *
     * @return string
     */
    public function serverName(): string
    {
        return $this->string("SERVER_NAME", "localhost");
    }

    /**
     * get server port
     *
     * @return int
     */
    public function serverPort(): int
    {
        return $this->int("SERVER_PORT", 80);
    }

    /**
     * get server protocol
     *
     * @return string
     */
    public function serverProtocol(): string
    {
        return $this->string("SERVER_PROTOCOL");
    }

    /**
     * get server signature
     *
     * @return string
     */
    public function serverSignature(): string
    {
        return $this->string("SERVER_SIGNATURE");
    }

    /**
     * get server software
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
     * whether is http key
     *
     * @param string $key
     * @return bool
     */
    protected function isHttpKey(string $key): bool
    {
        return str_starts_with($key, "HTTP_");
    }

    /**
     * get http key
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
     * get http headers
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
     * get http header
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
     * get http host
     *
     * @return string
     */
    public function httpHost(): string
    {
        return $this->header("HOST", $this->serverName());
    }

    /**
     * get http user agent
     *
     * @return string
     */
    public function userAgent(): string
    {
        return $this->header("USER_AGENT");
    }

    /**
     * get http cache control
     *
     * @return string
     */
    public function cacheControl(): string
    {
        return $this->header("CACHE_CONTROL");
    }

    /**
     * get http accept
     *
     * @return string
     */
    public function accept(): string
    {
        return $this->header("ACCEPT");
    }

    /**
     * whether request is ajax
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
     * get client ip address
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
     * get request url
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
