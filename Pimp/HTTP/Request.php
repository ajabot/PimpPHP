<?php

namespace Pimp\HTTP;


/**
 * Request management
 */
class Request
{
    private $method;
    private $uri;
    private $headers;
    private $post;
    private $server;
    private $put;

    /**
     * Object set up
     * Once instanciate, our Request can give us all we need: $_POST and $_SERVER parameters, put parameters, headers
     *
     * @return void
     */
    public function __construct(array $server = null, array $post = null, array $headers = null, array $put = null)
    {
        if (!$server) {
            $server = $_SERVER;
        }

        if (!$post) {
            $post = $_POST;
        }

        if (!$headers) {
            //phpunit doesn't support getallheaders
            if (!function_exists('getallheaders')) {
                foreach ($server as $key => $value)
                {
                    if (substr($key,0,5)=="HTTP_") {
                        $key = str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5)))));
                        $headers[$key] = $value;
                    }
                }
            } else {
                $headers = getallheaders();
            }
        }

        if (!$put) {
            parse_str(file_get_contents("php://input"), $put);
        }

        $this->method  = $server['REQUEST_METHOD'];
        $this->uri     = $server['REQUEST_URI'];
        $this->server  = $server;
        $this->post    = $post;
        $this->headers = $headers;
        $this->put     = $put;
    }

    /**
     * Returns the method of the request (ex: POST, GET)
     *
     * @return string the method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Returns the requested URI (ex: /address/1)
     *
     * @return string the uri
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Returns the SERVER parameters
     *
     * @return array the $_SERVER parameters
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Returns POST parameters
     *
     * @return array the POST parameters
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Returns the request's headers
     *
     * @return array the headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Returns the request's put parameters
     *
     * @return array the put parameters
     */
    public function getPut()
    {
        return $this->put;
    }
}
