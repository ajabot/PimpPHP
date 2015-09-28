<?php

namespace Test\Pimp\HTTP;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testGetContent()
    {
        $contentStub = 'this is a test content';
        $response = new \Pimp\HTTP\Response($contentStub);

        $this->assertEquals('this is a test content', $response->getContent());
    }

}