<?php

namespace Pimp\Model;

use Pimp\Model\DataGatewayInterface;
/**
 * The mother of all Model type classes
 */
class Model
{
    protected $gateway;

    /**
     * Sets the data gateway that will be used by the models
     *
     * @param DataGatewayInterface $gateway the storage system management
     *
     * @return void
     */
    public function __construct(DataGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }
}
