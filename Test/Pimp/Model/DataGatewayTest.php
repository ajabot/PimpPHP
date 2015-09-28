<?php

namespace Test\Pimp\Model;

class DataGatewayTest extends \PHPUnit_Framework_TestCase
{
    public function testget()
    {
        $dataStub  = array(
            array('Michal', '506088156', 'Michalowskiego 41'),
            array('Marcin', '502145785', 'Opata Rybickiego 1')
        );


        $fileHandlerStub = $this->getMock('Pimp\Helper\CSVHandler');
        $fileHandlerStub->expects($this->any())
        ->method('read')
        ->will($this->returnValue($dataStub));

        $dataGateway = new \Pimp\Model\DataGateway($fileHandlerStub);

        $this->assertInstanceOf('Pimp\Model\DataGatewayInterface', $dataGateway);

        $data = $dataGateway->get('fakefile.csv');

        $this->assertSame($dataStub, $data);
    }
}
