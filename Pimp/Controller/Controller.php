<?php

namespace Pimp\Controller;

use Pimp\DependencyInjection\Container;
use Pimp\HTTP\Response;

/**
 * The mother of all Controller type classes
 */
class Controller
{
    /**
     * @var Container $container the container object used to manage services
     */
    protected $container;

    /**
     * Object set up
     *
     * @param Container $container our service manager
     *
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Return the service Object requested from service container
     *
     * @param string $service
     *
     * @return mixed the service Object
     */
    public function get($service)
    {
        return $this->container->get($service);
    }

    /**
     * Parse the given template with the given parameters using the template engine
     *
     * @param string $templatePath the path to the template file we want to parse
     * @param params $params       the array containing the variable to fill in the template
     *
     * @return string the parsed template
     */
    public function render($templatePath, $params)
    {
        return new Response(
            $this->container->get('template')->render($templatePath, $params)
        );
    }
}
