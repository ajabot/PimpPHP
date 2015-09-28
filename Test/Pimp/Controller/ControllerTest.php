<?php
namespace Test\Pimp\Controller;

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $containerStub = $this->getMock('Pimp\DependencyInjection\Container');
        $serviceStub = $this->getMockBuilder('Pimp\HTTP\Request')
                     ->disableOriginalConstructor()
                     ->getMock();
        
        $containerStub->expects($this->any())
                  ->method('get')
                  ->will($this->returnValue($serviceStub));

        $controller = new \Pimp\Controller\Controller($containerStub);
        $response = $controller->get("stub");

        $this->assertInstanceOf('Pimp\HTTP\Request', $response);
        $this->assertSame($serviceStub, $response);
    }
    
    public function testGetNonExistingService()
    {
        $containerStub = $this->getMock('Pimp\DependencyInjection\Container');

        $containerStub->expects($this->any())
        ->method('get')
        ->will($this->returnValue(null));
    
        $controller = new \Pimp\Controller\Controller($containerStub);
        $response = $controller->get("stub");
    
        $this->assertNull($response);
    }
}