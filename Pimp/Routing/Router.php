<?php

namespace Pimp\Routing;

use Pimp\Routing\Route;

/**
 * This is the route manager that the application interact with
 */
class Router
{
    /**
     * @var array the routes defined for our application
     */
    private $routes = array();

    /**
     * Add a new route to the application
     *
     * @param string $pattern    the route pattern
     * @param string $controller the controller that will manage the request coming through this route
     * @param string $method     the method of the route (ex: GET)
     *
     * @return void
     */
    public function map($pattern, $controller, $method)
    {
        $this->routes[$method][] = new Route($pattern, $controller, $method);
    }

    /**
     * Return the route matching the requested uri and method
     * Throws an Exception if no route is found
     *
     * @param string $uri    the requested URI
     * @param string $method the requested method (ex: POST)
     *
     * @throws \Exception
     *
     * @return \Pimp\Routing\Route the matching route
     */
    public function getMatchingRoute($uri, $method)
    {
        if (!isset($this->routes[$method]) || !is_array($this->routes[$method])) {
            throw new \Exception("No route found");
        }

        foreach ($this->routes[$method] as $route) {
            if ($method != $route->getMethod()) {
                continue;
            }

            if ($route->matches($uri)) {
                return $route;
            }
        }

        throw new \Exception("No route found");
    }

    /**
     * Parse the given URI with the route's pattern to extract the parameters sent by the user
     * Throws an Exception if the uri does not match the route
     *
     * @param Route  $route the route matching the uri
     * @param string $uri   the requested URI
     *
     * @throws \Exception
     *
     * @return array the parameters from the URI
     */
    public function getRouteParams(Route $route, $uri)
    {
        if (!$route->matches($uri)) {
            throw new \Exception("Route doesn't match");
        }

        $params = array();
        $routeParts = explode("/", trim($route->getPattern(), "/"));
        $uriParts = explode("/", trim($uri, "/"));

        foreach ($routeParts as $index => $part) {
            if ($part != $uriParts[$index]) {
                $params[] = $uriParts[$index];
            }
        }

        return $params;
    }
}
