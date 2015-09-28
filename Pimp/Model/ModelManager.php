<?php

namespace Pimp\Model;

use Pimp\Model\DataGatewayInterface;
use Pimp\Model\Model;

/**
 * Service that gets any requested model for other Objects
 */
class ModelManager
{
    private $dataGateway;

    /**
     * Sets the data gateway that will be used by the models
     *
     * @param DataGatewayInterface $gateway the storage system management
     *
     * @return void
     */
    public function __construct(DataGatewayInterface $dataGateway)
    {
        $this->dataGateway = $dataGateway;
    }

    /**
     * Gets a model instance for another object
     *
     * @param string $modelClass the requested model
     *
     * @return Model the requested model
     */
    public function get($modelClass)
    {
        $className = $modelClass . 'Model';

        if (!class_exists($className)) {
      		throw new \Exception("Model not found");
      	}

      	$model = new $className($this->dataGateway);


      	if (!($model instanceof Model)) {
      		throw new \Exception("Model not found");
      	}
        
        return $model;
    }
}
