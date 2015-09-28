<?php

namespace Pimp\Routing;

use Pimp\DependencyInjection\Container;
/**
 *
 */
class Route
{
    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';
    const PUT_METHOD = 'PUT';
    const DELETE_METHOD = 'DELETE';

    private $pattern;
    private $controller;
    private $method;

    /**
     * Sets the information for a Route set by the application
     *
     * @param string $pattern    the pattern of the route, variable parts are prefixed with ':' (ex: /address/:id)
     * @param string $controller the controller that will be used to manage the request matching the route. format controllerClass:Method
     * @param string $method     the method the user has to call the route with (ex: POST, PUT)
     *
     * @return void
     */
    public function __construct($pattern, $controller, $method)
    {
        $this->pattern = $pattern;
        $this->method = $method;
        $this->controller = $controller;
    }

    /**
     * Gets the route's method (ex: DELETE)
     *
     * @return string the method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Gets the route's pattern (ex: /address/:id)
     *
     * @return string the pattern
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Gets the route's controller (ex: Project\Controller\Address:getAction)
     *
     * @return string the controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns true if a given URI matches the route's pattern
     *
     * @param string $uri the requested URI
     *
     * @return bool
     */
    public function matches($uri)
    {
        //we replace the variables of the route pattern with regexp elements to be able to compare to URI
        $regexp = '#^' . preg_replace('/:[a-zA-Z]+/', '(\w| )+', $this->pattern) . '$#';

        if (preg_match($regexp, $uri) == 1) {
            return true;
        }
        return false;
    }
}
