<?php

namespace Test\Pimp\DependencyInjection;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetSettings()
    {
        $container = new \Pimp\DependencyInjection\Container();

        $settingsStub = array(
            'view_directory' => 'View',
            'compile_directory' => 'View/Compile',
            'cache_directory' => 'View/Cache',
        );

        $container->setSettings($settingsStub);

        $this->assertEquals('View', $container->getSetting('view_directory'));
        $this->assertEquals('View/Compile', $container->getSetting('compile_directory'));
        $this->assertEquals('View/Cache', $container->getSetting('cache_directory'));
        $this->assertNull($container->getSetting('foo'));
    }

    public function testSetGetService()
    {
        $routerStub = $this->getMock('Pimp\Routing\Router');
        $requestStub = $this->getMockBuilder('Pimp\HTTP\Request')
                     ->disableOriginalConstructor()
                     ->getMock();


        $container = new \Pimp\DependencyInjection\Container();

        $container->addService('router', $routerStub);
        $container->addService('request', $requestStub);

        $this->assertInstanceOf('Pimp\Routing\Router', $container->get('router'));
        $this->assertSame($routerStub, $container->get('router'));
        $this->assertInstanceOf('Pimp\HTTP\Request', $container->get('request'));
        $this->assertSame($requestStub, $container->get('request'));
    }

    /**
     * @expectedException \Exception
     */
    public function testSetGetServiceFail()
    {
        $container = new \Pimp\DependencyInjection\Container();
        $container->get('foo');
    }
}
