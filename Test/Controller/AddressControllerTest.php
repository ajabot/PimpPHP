<?php
namespace Test\Controller;

class AddressControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAction()
    {
        $containerStub = $this->getMock('Pimp\DependencyInjection\Container');
        $containerStub->expects($this->any())
                  ->method('get')
                  ->with($this->logicalOr("modelManager", "request", "responseFormatter"))
                  ->will($this->returnCallBack(array($this, 'getStub')));

        $controller = new \Project\Controller\AddressController($containerStub);

        $response = $controller->getAction(0);
        //Controllers are supposed to return Response objects
        $this->assertInstanceOf('Pimp\HTTP\Response', $response);

        $this->assertEquals('{"name":"Michal","phone":"506088156","street":"Michalowskiego 41"}', $response->getContent());

        //checking that we don't have an issue and we're always getting the same row from the model
        $response = $controller->getAction(1);
        $this->assertEquals('{"name":"Marcin","phone":"502145785","street":"Opata Rybickiego 1"}', $response->getContent());
    }

    public function getStub($service)
    {
        if ($service == 'modelManager') {
            $dataStub  = array(
                array(
                    "name" => "Michal",
                    "phone" => "506088156",
                    "street" => "Michalowskiego 41"
                ),
                array(
                    "name" => "Marcin",
                    "phone" => "502145785",
                    "street" => "Opata Rybickiego 1"
                )
            );

            $modelStub = $this->getMockBuilder('Project\Model\AddressModel')
                        ->disableOriginalConstructor()
                        ->getMock();
            $modelStub->expects($this->any())
                      ->method('get')
                      ->will($this->returnValue($dataStub));

            $modelManagerStub = $this->getMockBuilder('Pimp\Model\ModelManager')
                        ->disableOriginalConstructor()
                        ->getMock();

            $modelManagerStub->expects($this->any())
                      ->method('get')
                      ->will($this->returnValue($modelStub));
            return $modelManagerStub;
        } elseif ($service == 'request') {
            $requestStub = $this->getMockBuilder('Pimp\HTTP\Request')
                              ->disableOriginalConstructor()
                              ->getMock();


            $requestStub->expects($this->any())
                      ->method('getHeaders')
                      ->will($this->returnValue(array('Accept' => '*/*')));

            return $requestStub;
        } elseif ($service == 'responseFormatter') {
            $formatterStub = $this->getMock('Pimp\Helper\ResponseFormatter');
            $formatterStub->expects($this->any())
                      ->method('format')
                      ->with($this->anything())
                      ->will($this->returnCallBack(array($this, 'getFormattedStub')));
            return $formatterStub;
        }
    }

    public function getFormattedStub($content, $accept_header)
    {
        return new \Pimp\HTTP\Response(json_encode($content), 200, $accept_header);
    }
}
