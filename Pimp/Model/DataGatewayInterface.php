<?php

namespace Pimp\Model;

/**
 * The interface for our application's data gateways
 */
interface DataGatewayInterface
{
    public function get($params);
    public function insert($params);
    public function update($params);
    public function delete($params);
}
