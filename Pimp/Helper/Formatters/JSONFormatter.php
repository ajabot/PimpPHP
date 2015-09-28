<?php

namespace Pimp\Helper\Formatters;

use Pimp\Helper\ContentFormatterInterface;
/**
 * The application's JSON formatter
 */
class JSONFormatter implements ContentFormatterInterface
{
    /**
     * return the given content json formatted
     *
     * @param array $content the content we want to format
     *
     * @return string the formatted content
     */
    public function format(array $content)
    {
        return json_encode($content);
    }
}
