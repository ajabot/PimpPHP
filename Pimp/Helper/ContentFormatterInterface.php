<?php

namespace Pimp\Helper;

/**
 * The interface for our application's Formatters
 */
interface ContentFormatterInterface
{
    public function format(array $content);
}
