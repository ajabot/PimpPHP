<?php

namespace Test\Pimp\HTTP;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    private function _getServerStub()
    {
        return array(
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => 'address/1'
        );
    }
    
    private function _getPostStub()
    {
        return array(
            'name' => 'foo',
            'address' => 'address street'
        );
    }
    
    public function testGetMethod()
    {
        $serverStub = $this->_getServerStub(); 
        
        $postStub = array();
        
        $request = new \Pimp\HTTP\Request($serverStub, $postStub);
        
        $this->assertEquals('GET', $request->getMethod());
    }
    
    public function testGetUri()
    {
        $serverStub = $this->_getServerStub();
    
        $postStub = array();
    
        $request = new \Pimp\HTTP\Request($serverStub, $postStub);
    
        $this->assertEquals('address/1', $request->getUri());
    }
    
    public function testGetServer()
    {
        $serverStub = $this->_getServerStub();
    
        $postStub = array();
    
        $request = new \Pimp\HTTP\Request($serverStub, $postStub);
    
        $this->assertEquals($serverStub, $request->getServer());
    }
    
    public function testGetPost()
    {
        $serverStub = $this->_getServerStub();
        $serverStub['REQUEST_METHOD'] = 'POST';
        
        $postStub = $this->_getPostStub();
    
        $request = new \Pimp\HTTP\Request($serverStub, $postStub);
    
        $this->assertEquals($postStub, $request->getPost());
    }
    
    
}