<?php

namespace Project\Controller;

use Pimp\Controller\Controller;
use Pimp\HTTP\Response;

/**
 * The controller managing the address route
 * @Route("/address")
 */
class AddressController extends Controller
{
    /**
     * Gets an address from the storage system
     * and returns a Response object containing an address (or a message is there is an error)
     *
     * @param int $id the ID of the address we want to get
     *
     * @return \Pimp\Http\Response
     */
    public function getAction($id)
    {
        $model = $this->get('modelManager')->get('Project\Model\Address');
        $addresses = $model->get();

        $headers = $this->get('request')->getHeaders();

        //we return a 404 error if the address is not found
        if (!isset($addresses[$id])) {
            return $this->_createFormattedResponse(
                array('message' => 'address not found'),
                Response::NOT_FOUND_CODE,
                $headers['Accept']
            );
        }
        return $this->_createFormattedResponse($addresses[$id], Response::OK_CODE, $headers['Accept']);
    }

    /**
     * Adds an address line in the storage system if the request parameters are good
     * and returns a Response object containing a success or an error message
     *
     * @return \Pimp\Http\Response
     */
    public function postAction()
    {
        $params = $this->get('request')->getPost();
        $headers = $this->get('request')->getHeaders();

        //A Validator object would be better, but for now we're just checking if all
        //parameters are not empty
        if (empty($params['name']) || empty($params['phone']) || empty($params['street'])) {
            return $this->_createFormattedResponse(
                array('message' => 'name, street and phone are mandatory'),
                Response::BAD_REQUEST_CODE,
                $headers['Accept']
            );
        }

        $model = $this->get('modelManager')->get('Project\Model\Address');
        $line = array($params['name'], $params['phone'], $params['street']);

        $model->add($line);

        return $this->_createFormattedResponse(array('message' => 'adress successfully created'), Response::OK_CODE, $headers['Accept']);
    }

    /**
     * Update the address line in the storage system and
     * returns a Response object containing a success or an error message
     *
     * @param int $int the ID of the address we want to update
     *
     * @return \Pimp\Http\Response
     */
    public function putAction($id)
    {
        $model = $this->get('modelManager')->get('Project\Model\Address');
        $params = $this->get('request')->getPut();
        $headers = $this->get('request')->getHeaders();

        $updatedLine = array();

        //We only the columns sent by the user
        if (!empty($params['name'])) {
            $updatedLine['name'] = $params['name'];
        }

        if (!empty($params['phone'])) {
            $updatedLine['phone'] = $params['phone'];
        }

        if (!empty($params['street'])) {
              $updatedLine['street'] = $params['street'];
        }

        $updatedLine['id'] = $id;
        $model->update($updatedLine);

        return $this->_createFormattedResponse(array('message' => 'adress successfully updated'), Response::OK_CODE, $headers['Accept']);
    }

    /**
     * Delete the address line in the storage system and
     * returns a Response object containing a success or an error message
     *
     * @param int $int the ID of the address we want to update
     *
     * @return \Pimp\Http\Response
     */
    public function deleteAction($id)
    {
        $headers = $this->get('request')->getHeaders();
        $model = $this->get('modelManager')->get('Project\Model\Address');
        $model->delete($id);

        return $this->_createFormattedResponse(array('message' => 'adress successfully deleted'), Response::OK_CODE, $headers['Accept']);
    }

    /**
     * Converts a content array and a status into a Response object
     * formatted to the request format
     *
     * @param array  $content the array of contents we want to set in the response
     * @param int    $status  the status code of the response (ex 200, 404)
     * @param string $format  the response's format request by the user
     *
     * @return \Pimp\Http\Response
     */
    private function _createFormattedResponse(array $content, $status, $format)
    {
        $response = $this->get('responseFormatter')->format($content, $format);
        $response->setStatus($status);

        return $response;
    }

}
