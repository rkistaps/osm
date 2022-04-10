<?php

declare(strict_types=1);

namespace OSM\Frontend\Core;

use TheApp\Components\Router;
use TheApp\Structures\Route;

class RouteCollector
{
    private array $middlewares = [];
    private string $prefix = '';
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function withPrefix(string $prefix): self
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function withMiddleware(string $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function collect(callable $callable)
    {
        $callable($this);
    }

    /**
     * @param string $path
     * @param string|callable $handler
     * @param string|null $name
     * @return Route
     */
    public function get(string $path, $handler, string $name = null): Route
    {
        $route = $this->router->get($this->prefix . $path, $handler, $name);

        foreach ($this->middlewares as $middleware) {
            $route = $route->withMiddleware($middleware);
        }

        return $route;
    }

    /**
     * @param string $path
     * @param string|callable $handler
     * @param string|null $name
     * @return Route
     */
    public function post(string $path, $handler, string $name = null): Route
    {
        $route = $this->router->post($this->prefix . $path, $handler, $name);

        foreach ($this->middlewares as $middleware) {
            $route = $route->withMiddleware($middleware);
        }

        return $route;
    }

    /**
     * @param string $path
     * @param $handler
     * @param string|null $name
     * @return Route
     */
    public function any(string $path, $handler, string $name = null): Route
    {
        $route = $this->router->any($this->prefix . $path, $handler, $name);

        foreach ($this->middlewares as $middleware) {
            $route = $route->withMiddleware($middleware);
        }

        return $route;
    }
}
