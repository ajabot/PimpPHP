<?php

namespace Pimp\Model;

use Pimp\Model\DataGatewayInterface;
use Pimp\Helper\FileHandlerInterface;

/**
 * The storage system abstraction
 */
class DataGateway implements DataGatewayInterface
{
    protected $fileHandler;

    /**
     * Sets the FileHandler that will be use to interact with our data file
     *
     * @param FileHandlerInterface $fileHandler our fileHandler (default = CSVHandler)
     *
     * @return void
     */
    public function __construct(FileHandlerInterface $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    /**
     * gets data from the storage system
     *
     * @param mixed $params the parameters to get what we want
     *
     * @return mixed what the storage system returned
     */
    public function get($params)
    {
        return $this->fileHandler->read($params);
    }

    /**
     * insert data into the storage system
     *
     * @param mixed $params the parameters to insert what we want
     *
     * @return void
     */
    public function insert($params)
    {
        $this->fileHandler->write($params['file'], $params['data'], $params['option']);
    }

    /**
     * updates data in the storage system
     *
     * @param mixed $params the parameters to update what we want
     *
     * @return void
     */
    public function update($params)
    {
        $this->fileHandler->write($params['file'], $params['data'], $params['option']);
    }

    /**
     * delete data from the storage system
     *
     * @param mixed $params the parameters to delete what we want
     *
     * @return void
     */
    public function delete($params)
    {
        $this->fileHandler->write($params['file'], $params['data'], $params['option']);
    }
}
