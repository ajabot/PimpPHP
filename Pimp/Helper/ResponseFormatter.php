<?php

namespace Pimp\Helper;

use Pimp\HTTP\Response;
use Pimp\Helper\ContentFormatterInterface;

/**
 * This helper formats the content and set the right header for the requested format
 */
class ResponseFormatter
{
    /**
     * Return a Response Object formatted (content and header) to the format requested
     * Throws and Exception if we don't have a Formatter for the requested format
     *
     * @param array  $content       the content we want to format
     * @param string $accept_header the header sent by the user containing the requested format
     *
     * @throws \Exception
     *
     * @return \Pimp\Http\Response
     */
    public function format(array $content, $accept_header)
    {
    	if (empty($accept_header) || $accept_header == '*/*') {
    		//default format = json
    		$accept_header = 'application/json';
    	}

      //getting our formatter object
    	$format = substr($accept_header, strpos($accept_header, "/") + 1);
    	$formatter_class = '\Pimp\Helper\Formatters\\' . strtoupper($format) . 'Formatter';

    	if (!class_exists($formatter_class)) {
    		throw new \Exception("Format not supported");
    	}

    	$formatter = new $formatter_class();


    	if (!($formatter instanceof ContentFormatterInterface)) {
    		throw new \Exception("Format not supported");
    	}

    	$response = new Response($formatter->format($content));
    	$response->setHeader($accept_header);

    	return $response;
 	}
}
