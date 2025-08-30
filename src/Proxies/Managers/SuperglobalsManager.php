<?php

declare(strict_types=1);

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\SingletonManager;

use Spark\Supports\Superglobals\Cookie;
use Spark\Supports\Superglobals\Env;
use Spark\Supports\Superglobals\Files;
use Spark\Supports\Superglobals\Get;
use Spark\Supports\Superglobals\Globals;
use Spark\Supports\Superglobals\Post;
use Spark\Supports\Superglobals\Server;
use Spark\Supports\Superglobals\Session;

/**
 * Superglobals Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class SuperglobalsManager extends SingletonManager
{
    /*----------------------------------------*
     * Singleton
     *----------------------------------------*/

    /**
     * Init singletons
     *
     * @return void
     */
    protected function initSingletons(): void
    {
        $this->addFactory(Cookie::class, fn() => new Cookie());
        $this->addFactory(Env::class, fn() => new Env());
        $this->addFactory(Files::class, fn() => new Files());
        $this->addFactory(Get::class, fn() => new Get());
        $this->addFactory(Globals::class, fn() => new Globals());
        $this->addFactory(Post::class, fn() => new Post());
        $this->addFactory(Server::class, fn() => new Server());
        $this->addFactory(Session::class, fn() => new Session());
    }

    /*----------------------------------------*
     * Accessor
     *----------------------------------------*/

    /**
     * Get cookie reference
     *
     * @return \Spark\Supports\Superglobals\Cookie
     */
    public function cookie(): Cookie
    {
        return $this->singleton(Cookie::class);
    }

    /**
     * Get env reference
     *
     * @return \Spark\Supports\Superglobals\Env
     */
    public function env(): Env
    {
        return $this->singleton(Env::class);
    }

    /**
     * Get files reference
     *
     * @return \Spark\Supports\Superglobals\Files
     */
    public function files(): Files
    {
        return $this->singleton(Files::class);
    }

    /**
     * Get get reference
     *
     * @return \Spark\Supports\Superglobals\Get
     */
    public function get(): Get
    {
        return $this->singleton(Get::class);
    }

    /**
     * Get globals reference
     *
     * @return \Spark\Supports\Superglobals\Superglobalss
     */
    public function globals(): Globals
    {
        return $this->singleton(Globals::class);
    }

    /**
     * Get post reference
     *
     * @return \Spark\Supports\Superglobals\Post
     */
    public function post(): Post
    {
        return $this->singleton(Post::class);
    }

    /**
     * Get server reference
     *
     * @return \Spark\Supports\Superglobals\Server
     */
    public function server(): Server
    {
        return $this->singleton(Server::class);
    }

    /**
     * Get session reference
     *
     * @return \Spark\Supports\Superglobals\Session
     */
    public function session(): Session
    {
        return $this->singleton(Session::class);
    }
}
