<?php
namespace Test\Model;

class AddressModelTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $expectedData  = array(
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

        $dataStub = array(
            array("Michal", "506088156", "Michalowskiego 41"),
            array("Marcin", "502145785", "Opata Rybickiego 1")
        );

        $gatewayStub = $this->getMockBuilder('Pimp\Model\DataGateway')
                    ->disableOriginalConstructor()
                    ->getMock();

        $gatewayStub->expects($this->any())
                  ->method('get')
                  ->will($this->returnValue($dataStub));

        $model = new \Project\Model\AddressModel($gatewayStub);

        $response = $model->get();
        $this->assertSame($expectedData, $response);
    }
}
