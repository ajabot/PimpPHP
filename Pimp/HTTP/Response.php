<?php

namespace Pimp\HTTP;


/**
 * Response management
 */
class Response
{
    const OK_CODE             = 200;
    const BAD_REQUEST_CODE    = 400;
    const NOT_FOUND_CODE      = 404;
    const INTERNAL_ERROR_CODE = 500;

    protected $status;
    protected $headers;
    protected $content;

    /**
     * Object set up
     * Sets the content, the status and the headers that will be sent to the user
     *
     * @param string $content the content to be sent to the user
     * @param int    $status  the status code to be sent to the use (ex: 404)
     * @param array  $headers the headers to be sent to the user
     *
     * @return void
     */
    public function __construct($content = '', $status = 200, $headers = array())
    {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
    }

    /**
     * return the response's content
     *
     * @return string the response's content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * return the response's status
     *
     * @return string the response's status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * set the response's status
     *
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * return the response's headers
     *
     * @return string the response's headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * add an header to the response
     *
     * @param string $header the header content
     *
     * @return void
     */
    public function setHeader($header)
    {
        $this->headers[] = $header;
    }
}
