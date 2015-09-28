<?php

namespace Pimp\View;

/**
 * The interface for the application's template engine
 */
interface TemplateInterface
{
    public function render($view, array $params);
    public function setViewDirectory($path);
    public function setCacheDirectory($path);
    public function setCompileDirectory($path);
}
