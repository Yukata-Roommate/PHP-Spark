<?php

namespace Spark\Proxies\Managers\Supports;

use Spark\Foundation\Proxy\SingletonManager;

use Spark\Supports\Global\Cookie;
use Spark\Supports\Global\Env;
use Spark\Supports\Global\Files;
use Spark\Supports\Global\Get;
use Spark\Supports\Global\Globals;
use Spark\Supports\Global\Post;
use Spark\Supports\Global\Server;
use Spark\Supports\Global\Session;

/**
 * Supports Global Proxy Manager
 *
 * @package Spark\Proxies\Managers\Supports
 */
class GlobalManager extends SingletonManager
{
    /*----------------------------------------*
     * Singleton
     *----------------------------------------*/

    /**
     * init singletons
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
     * get cookie reference
     *
     * @return \Spark\Supports\Global\Cookie
     */
    public function cookie(): Cookie
    {
        return $this->singleton(Cookie::class);
    }

    /**
     * get env reference
     *
     * @return \Spark\Supports\Global\Env
     */
    public function env(): Env
    {
        return $this->singleton(Env::class);
    }

    /**
     * get files reference
     *
     * @return \Spark\Supports\Global\Files
     */
    public function files(): Files
    {
        return $this->singleton(Files::class);
    }

    /**
     * get get reference
     *
     * @return \Spark\Supports\Global\Get
     */
    public function get(): Get
    {
        return $this->singleton(Get::class);
    }

    /**
     * get globals reference
     *
     * @return \Spark\Supports\Global\Globals
     */
    public function globals(): Globals
    {
        return $this->singleton(Globals::class);
    }

    /**
     * get post reference
     *
     * @return \Spark\Supports\Global\Post
     */
    public function post(): Post
    {
        return $this->singleton(Post::class);
    }

    /**
     * get server reference
     *
     * @return \Spark\Supports\Global\Server
     */
    public function server(): Server
    {
        return $this->singleton(Server::class);
    }

    /**
     * get session reference
     *
     * @return \Spark\Supports\Global\Session
     */
    public function session(): Session
    {
        return $this->singleton(Session::class);
    }
}
