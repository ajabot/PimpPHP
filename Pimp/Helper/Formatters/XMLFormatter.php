<?php

namespace Pimp\Helper\Formatters;


use Pimp\Helper\ContentFormatterInterface;
/**
 * The application's XML formatter
 */
class XMLFormatter implements ContentFormatterInterface
{
    /**
     * return the given content xml formatted
     *
     * @param array $content the content we want to format
     *
     * @return string the formatted content
     */
    public function format(array $content)
    {
        $header = "<?xml version='1.0' encoding='UTF-8'?>";

        return $header . '<response>' . $this->_renderOutput($content) . '</response>';
    }

    /**
     * Recursive method that create the xml tags
     *
     * @param array $content the content we want to format
     *
     * @return string the formatted content
     */
    private function _renderOutput($content)
    {
        $output = '';
        if (is_array($content)) {
            foreach($content as $key => $value) {
                $output .= '<' . $key . '>' . $this->_renderOutput($value) . '</' . $key . '>';
            }
        } else {
            //adding CDATA in case the content contains characters that can invalid the xml file
            $output = '<![CDATA[' . $content . ']]>';
        }

        return $output;
    }
}
