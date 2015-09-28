<?php

namespace Pimp\Helper;

/**
 * The interface for the application's file handlers
 */
interface FileHandlerInterface
{
    public function read($fileName);
    public function write($fileName, $data, $options);
}
