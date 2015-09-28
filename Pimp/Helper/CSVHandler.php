<?php

namespace Pimp\Helper;

use Pimp\Helper\FileHandlerInterface;

/**
 * The helper for read and write in CSV files
 */
class CSVHandler implements FileHandlerInterface
{

    /**
     * Returns an array containing the file's lines
     * throws an Exception if we can't read the file
     *
     * @param string $fileName the path to the file we want to read
     *
     * @throws \Exception
     *
     * @return array the file lines
     */
    public function read($fileName)
    {
        $content = array();

        if (!file_exists($fileName)) {
            throw new \Exception("Unable to read file");
        }
        $file = fopen($fileName, 'r');

        if (!$file) {
            throw new \Exception("Unable to read file");
        }

        while ( ($line = fgetcsv($file)) !== FALSE ) {
            $content[] = $line;
        }

        fclose($file);

        return $content;
    }

    /**
     * Insert lines in a given file
     * throws Exception if we can't write in file
     *
     * @param string $fileName the path to the file we want to write in
     * @param array  $data     array containing the lines we want to insert
     * @param string $option   fopen options
     *
     * @throws \Exception
     *
     * @return array the file lines
     */
    public function write($fileName, $data, $option = 'w')
    {
        $file = fopen($fileName, $option);

        if (!$file) {
            throw new \Exception('Unable to open file for writing');
        }

        foreach ($data as $line) {
            $success = fputcsv($file, $line);
        }

        if (!$success) {
            throw new \Exception('Unable to write in file');
        }
    }
}
