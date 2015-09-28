<?php

namespace Pimp\View;

use Pimp\View\TemplateInterface;
/**
 * The basic template engine for our application
 */
class Template implements TemplateInterface
{
    private $view_path;
    private $cache_path;
    private $compile_path;

    /**
     * Returns the text from the template parsed with the parameters
     * In our case, we just convert the params to JSON
     *
     * @param string $view   the path to the template file
     * @param array  $params the parameters we parse the template with
     *
     * @return string the result of the template parsing
     */
    public function render($view, array $params)
    {
        return json_encode($params);
    }

    /**
     * Setting the path to the templates files directory
     *
     * @param string $path the path to the template directory
     *
     * @return void
     */
    public function setViewDirectory($path)
    {
        $this->view_path = $path;
    }

    /**
     * Setting the path to the cache files directory
     *
     * @param string $path the path to the template cache directory
     *
     * @return void
     */
    public function setCacheDirectory($path)
    {
        $this->cache_path = $path;
    }

    /**
     * Setting the path to the compiled files directory
     *
     * @param string $path the path to the compiled files directory
     *
     * @return void
     */
    public function setCompileDirectory($path)
    {
        $this->compile_path = $path;
    }
}
