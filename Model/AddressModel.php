<?php

namespace Project\Model;

use Pimp\Model\Model;

/**
 * The model managing the addresses
 */
class AddressModel extends Model
{
    //The CSV file used to store the addresses
    const ADDRESS_FILE = "Assets/address.csv";

    /**
     * Returns a collection of addresses from a storage system
     *
     * @return array the addreses
     */
    public function get() {
        $addresses = array();
        $lines = $this->gateway->get(dirname(__FILE__) . DIRECTORY_SEPARATOR . self::ADDRESS_FILE);

        //reformatting the response from the storage system to add columns name
        foreach ($lines as $line) {
            $addresses[] = array(
                "name" => $line[0],
                "phone" => $line[1],
                "street" => $line[2]
            );
        }

        return $addresses;
    }

    /**
     * Add a new line in the storage system. Throws an Exception if there is
     * something wrong with the storage system
     *
     * @param array the array containing all the needed params to add a new line
     *
     * @throws \Exception
     *
     * @return void
     */
    public function add(array $params)
    {
        $params = array_map("htmlspecialchars", $params);

        $params = array(
            'file'    => dirname(__FILE__) . DIRECTORY_SEPARATOR . self::ADDRESS_FILE,
            'option'  => 'a+',
            'data'    => array($params)
        );

        $this->gateway->insert($params);
    }

    /**
     * Update an existing line in the storage system. Throws an Exception if there is
     * something wrong with the storage system
     *
     * @param array the array containing all the needed params to update a line
     *
     * @throws \Exception
     *
     * @return void
     */
    public function update(array $params)
    {
        $addresses = $this->get();
        $id = $params['id'];

        if (!isset($addresses[$id])) {
            throw new \Exception('address not found');
        }

        //We only update the columns sent by the user
        if (!empty($params['name'])) {
            $addresses[$id]['name'] = htmlspecialchars($params['name']);
        }

        if (!empty($params['phone'])) {
            $addresses[$id]['phone'] = htmlspecialchars($params['phone']);
        }

        if (!empty($params['street'])) {
            $addresses[$id]['street'] = htmlspecialchars($params['street']);
        }

        $params = array(
            'file'    => dirname(__FILE__) . DIRECTORY_SEPARATOR . self::ADDRESS_FILE,
            'option'  => 'w',
            'data'    => $addresses
        );

        $this->gateway->update($params);
    }

    /**
     * Delete an existing line in the storage system. Throws an Exception if there is
     * something wrong with the storage system
     *
     * @param array the array containing all the needed params to delete a line
     *
     * @throws \Exception
     *
     * @return void
     */
    public function delete($id)
    {
        $addresses = $this->get();

        if (!isset($addresses[$id])) {
            throw new \Exception('address not found');
        }

        unset($addresses[$id]);

        $params = array(
            'file'    => dirname(__FILE__) . DIRECTORY_SEPARATOR . self::ADDRESS_FILE,
            'option'  => 'w',
            'data'    => $addresses
        );

        $this->gateway->delete($params);
    }

}
